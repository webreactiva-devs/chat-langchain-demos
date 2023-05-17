import { HNSWLib } from "langchain/vectorstores";
import { OpenAIEmbeddings } from "langchain/embeddings";
import { JSONLoader } from "langchain/document_loaders";
import pkg from "telegram-chat-parser";
import fs from "fs";
import * as dotenv from "dotenv";
import { RecursiveCharacterTextSplitter } from "langchain/text_splitter";
dotenv.config();

const openAIData = { openAIApiKey: process.env.OPENAI_API_KEY };

function getTwitchComments() {
  // configure options (optional)
  const options = {
    includeStickersAsEmoji: true,
  };

  // Load chat
  const json = fs.readFileSync("./chat.json", {
    encoding: "utf8",
    flag: "r",
  });

  const chat = JSON.parse(json);
  const formattedMessages = chat.comments.map((comment) => {
    return `${comment.commenter.display_name}: ${comment.message.body}`;
  });

  function filterLast7Days(array) {
    const today = new Date();
    const sevenDaysAgo = new Date(today.getTime() - 21 * 24 * 60 * 60 * 1000);

    return array.filter((element) => {
      const elementDate = new Date(element.date);
      return elementDate >= sevenDaysAgo && elementDate <= today;
    });
  }

  return formattedMessages;
}

export const run = async () => {
  const messages = getTwitchComments();
  console.dir(messages, { depth: null });

  const json = JSON.stringify(messages, null, 2);

  fs.writeFile("twitch_simplified.json", json, (err) => {
    if (err) {
      console.error(err);
      return;
    }
    console.log("File written successfully");
  });

  const directory = "database-twitch";
  const loader = new JSONLoader("twitch_simplified.json");
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
