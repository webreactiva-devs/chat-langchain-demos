import { HNSWLib } from "langchain/vectorstores";
import { OpenAIEmbeddings } from "langchain/embeddings";
import { JSONLoader } from "langchain/document_loaders";
import fs from "fs";
import * as dotenv from "dotenv";
import {
  MarkdownTextSplitter,
  RecursiveCharacterTextSplitter,
} from "langchain/text_splitter";
import { processMarkDownFiles } from "./utils.js";
dotenv.config();

const openAIData = { openAIApiKey: process.env.OPENAI_API_KEY };

export const run = async () => {
  const rawDocs = await processMarkDownFiles("./astro-markdown");

  console.log(rawDocs);
  const directory = "database-markdown";
  const splitter = new MarkdownTextSplitter({
    chunkSize: 1024,
    chunkOverlap: 200,
  });

  // const textSplitter = new RecursiveCharacterTextSplitter({
  //   chunkSize: 1000,
  //   chunkOverlap: 200,
  // });

  const docs = await splitter.splitDocuments(rawDocs);

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
