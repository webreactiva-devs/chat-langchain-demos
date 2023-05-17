import readline from "readline";
import { OpenAIEmbeddings } from "langchain/embeddings/openai";
import { HNSWLib } from "langchain/vectorstores/hnswlib";
import { VectorDBQAChain } from "langchain/chains";
import { OpenAIChat } from "langchain/llms/openai";
import { CallbackManager } from "langchain/callbacks";
import path from "path";
import { ChatOpenAI } from "langchain/chat_models/openai";

enum OpenAIModel {
  DAVINCI_TURBO = "gpt-3.5-turbo",
  GPT_4 = "gpt-4",
}

const dataFolder = "./demo3/data/vectordb/maquinillo";

async function run(prompt: string) {
  // Inputs
  const directory = path.resolve(process.cwd(), dataFolder);
  //let answer = "";

  // Vector DB
  const loadedVectorStore = await HNSWLib.load(
    directory,
    new OpenAIEmbeddings()
  );

  // const encoder = new TextEncoder();
  // const stream = new TransformStream();
  // const writer = stream.writable.getWriter();

  const llm = new ChatOpenAI({
    temperature: 0.0,
    streaming: false,
    modelName: OpenAIModel.DAVINCI_TURBO,
  });

  const chain = VectorDBQAChain.fromLLM(llm, loadedVectorStore, {
    returnSourceDocuments: true,
    k: 4,
  });

  const answer = await chain
    .call({
      query: prompt,
    })
    .catch(console.error);

  return answer;
}

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout,
  prompt: "Soy el clon de Robotito, ¿qué quieres saber?> ",
});

rl.prompt();

rl.on("line", async (line) => {
  if (line.toLowerCase() === "exit") {
    console.log("\nExiting!\n");
    process.exit(0);
  } else {
    const response = await run(line);
    console.dir(response, { depth: null });
    rl.close();
  }
  rl.prompt();
}).on("close", () => {
  console.log("Exiting!");
  process.exit(0);
});
