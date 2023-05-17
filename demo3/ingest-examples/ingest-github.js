import { HNSWLib } from "langchain/vectorstores";
import { OpenAIEmbeddings } from "langchain/embeddings";
import { GithubRepoLoader, JSONLoader } from "langchain/document_loaders";
import pkg from "telegram-chat-parser";
import fs from "fs";
import * as dotenv from "dotenv";
import { RecursiveCharacterTextSplitter } from "langchain/text_splitter";
dotenv.config();

const openAIData = { openAIApiKey: process.env.OPENAI_API_KEY };

export const run = async () => {
  const directory = "database-github";
  const loader = new GithubRepoLoader(
    "https://github.com/delineas/calendar-events-api",
    { branch: "master", recursive: true, unknown: "warn" }
  );
  const rawDocs = await loader.load();
  // exclude all filenames with json extension

  const filterDocs = rawDocs.filter(
    (doc) => !doc.metadata.source.endsWith("lock")
  );

  const textSplitter = new RecursiveCharacterTextSplitter({
    chunkSize: 1024,
    chunkOverlap: 200,
  });

  const docs = await textSplitter.splitDocuments(filterDocs);

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
