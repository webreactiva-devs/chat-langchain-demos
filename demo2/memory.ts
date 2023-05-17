import readline from "readline";
import { ChatOpenAI } from "langchain/chat_models/openai";
import { BufferMemory, ChatMessageHistory } from "langchain/memory";
import {
  AIChatMessage,
  BaseChatMessage,
  HumanChatMessage,
  SystemChatMessage,
} from "langchain/schema";
import { ConversationChain } from "langchain/chains";
import {
  ChatPromptTemplate,
  HumanMessagePromptTemplate,
  MessagesPlaceholder,
  SystemMessagePromptTemplate,
} from "langchain/prompts";

function mapStoredMessagesToChatMessages(
  messages: BaseChatMessage[]
): BaseChatMessage[] {
  return messages.map((message) => {
    switch (message.name) {
      case "human":
        return new HumanChatMessage(message.text);
      case "ai":
        return new AIChatMessage(message.text);
      case "system":
        return new SystemChatMessage(message.text);
      default:
        throw new Error("Role must be defined for generic messages");
    }
  });
}

async function run(
  prompt: string,
  messages: BaseChatMessage[]
): Promise<BaseChatMessage> {
  const chat = new ChatOpenAI({
    streaming: false,
    maxRetries: 1,
  });

  const lcChatMessageHistory = new ChatMessageHistory(
    mapStoredMessagesToChatMessages(messages)
  );
  const memory = new BufferMemory({
    chatHistory: lcChatMessageHistory,
    returnMessages: true,
    memoryKey: "history",
  });

  const chatPrompt = ChatPromptTemplate.fromPromptMessages([
    SystemMessagePromptTemplate.fromTemplate(
      "Eres un asistente amigable que sabe mucho de historia. Responde SIEMPRE en español."
    ),
    new MessagesPlaceholder("history"),
    HumanMessagePromptTemplate.fromTemplate("{input}"),
  ]);

  const chain = new ConversationChain({
    memory: memory,
    llm: chat,
    prompt: chatPrompt,
  });

  const res = await chain.call({
    input: prompt,
  });

  // console.dir(lcChatMessageHistory.getMessages(), { depth: null });

  return {
    text: res.response,
    name: "ai",
    _getType() {
      return "ai";
    },
  };
}

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout,
  prompt: "Soy un bot con memoria, ¿qué quieres saber?> ",
});

rl.prompt();

const inputMessages: BaseChatMessage[] = [];

rl.on("line", async (line) => {
  if (line.toLowerCase() === "exit") {
    console.log("\nExiting!\n");
    process.exit(0);
  } else {
    const response = await run(line, inputMessages);
    console.log(response.text);
    inputMessages.push(response);
  }
  rl.prompt();
}).on("close", () => {
  console.log("Exiting!");
  process.exit(0);
});
