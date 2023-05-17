import { HNSWLib } from "langchain/vectorstores";
import { OpenAIEmbeddings } from "langchain/embeddings";
import { JSONLoader } from "langchain/document_loaders";
import pkg from "telegram-chat-parser";
const { TelegramChat } = pkg;
import fs from "fs";
import * as dotenv from "dotenv";
import { RecursiveCharacterTextSplitter } from "langchain/text_splitter";
dotenv.config();

const openAIData = { openAIApiKey: process.env.OPENAI_API_KEY };

function getTelegramMessages() {
  // configure options (optional)
  const options = {
    includeStickersAsEmoji: true,
  };

  // Load chat
  const json = fs.readFileSync("./result.json", {
    encoding: "utf8",
    flag: "r",
  });
  const chat = new TelegramChat(json, options);

  // Get all messages
  const allMessages = chat.messages;

  const realMessages = chat.messages
    .filter((msg) => msg.isMessage)
    .filter((msg) => msg.text() !== "");
  console.log(realMessages);
  const messages = realMessages.map((msg) => ({
    id: msg.id,
    from: msg.from.name,
    reply_to_id: msg._data.reply_to_message_id,
    replies: [],
    date: msg.date,
    text: msg.text(),
  }));

  function nestMessages(messages) {
    const nestedMessages = [];
    messages.forEach((message) => {
      if (!message.reply_to_id) {
        // Si el mensaje no es una respuesta a otro mensaje, lo agregamos directamente
        nestedMessages.push({ ...message, replies: [] });
      } else {
        // Si el mensaje es una respuesta a otro mensaje, buscamos su padre en la lista
        const parent = nestedMessages.find((m) => m.id === message.reply_to_id);
        if (parent) {
          // Si encontramos al padre, agregamos este mensaje a su lista de respuestas
          parent.replies.push({ ...message, replies: [] });
        } else {
          // Si no encontramos al padre, lo agregamos al final de la lista como si no fuera una respuesta
          nestedMessages.push({ ...message, replies: [] });
        }
      }
    });
    // Recursivamente anidamos los mensajes de las respuestas
    nestedMessages.forEach((message) => {
      if (message.replies.length > 0) {
        message.replies = nestMessages(message.replies);
      }
    });
    return nestedMessages;
  }

  const nestedMessages = nestMessages(messages);
  //console.dir(nestMessages(messages), { depth: null });

  function filterLast7Days(array) {
    const today = new Date();
    const sevenDaysAgo = new Date(today.getTime() - 21 * 24 * 60 * 60 * 1000);

    return array.filter((element) => {
      const elementDate = new Date(element.date);
      return elementDate >= sevenDaysAgo && elementDate <= today;
    });
  }

  const formattedMessages = filterLast7Days(nestedMessages)
    .filter((msg) => msg.reply_to_id != undefined)
    .map((msg) => {
      const newMessage = `${msg.from} comenta el ${new Date(msg.date)
        .toISOString()
        .slice(0, 19)}: ${msg.text}\n\n`;
      const newReplies =
        msg.replies.length > 0
          ? msg.replies.reduce((acc, reply) => {
              return `${acc}\n ${reply.from} responde: ${reply.text}\n`;
            }, "\n")
          : "";
      return `${newMessage} ${newReplies}`;
    });

  return formattedMessages;
}

export const run = async () => {
  const messages = getTelegramMessages();
  console.dir(messages, { depth: null });

  // const json = JSON.stringify(messages, null, 2);

  // fs.writeFile("result_simplified.json", json, (err) => {
  //   if (err) {
  //     console.error(err);
  //     return;
  //   }
  //   console.log("File written successfully");
  // });

  const directory = "database-telegram";
  const loader = new JSONLoader("result_simplified.json");
  const rawDocs = await loader.load();
  //console.log(docs);

  const textSplitter = new RecursiveCharacterTextSplitter({
    chunkSize: 1000,
    chunkOverlap: 200,
  });

  const docs = await textSplitter.splitDocuments(rawDocs);

  // Create a vector store through any method, here from texts as an example
  const vectorStore = await HNSWLib.fromDocuments(
    docs,
    new OpenAIEmbeddings(openAIData)
  );

  // Save the vector store to a directory
  await vectorStore.save(directory);

  // // Load the vector store from the same directory
  // const loadedVectorStore = await HNSWLib.load(
  //   directory,
  //   new OpenAIEmbeddings(openAIData)
  // );

  // console.log(loadedVectorStore);
};

await run();
