import { HNSWLib } from "langchain/vectorstores";
import { OpenAIEmbeddings } from "langchain/embeddings";
import { RecursiveCharacterTextSplitter } from "langchain/text_splitter";
import * as path from "path";
import { fileURLToPath } from "url";
import {
  DirectoryLoader,
  JSONLoader,
  TextLoader,
} from "langchain/document_loaders";

const currentDir = path.dirname(fileURLToPath(import.meta.url));

export const run = async (sourceDir, outputDir) => {
  const ingestedPath = path.resolve(currentDir, `./data/${sourceDir}`);
  const docsPath = path.resolve(currentDir, `./data/${outputDir}`);

  const loader = new DirectoryLoader(ingestedPath, {
    ".json": (path) => new JSONLoader(path, "/texts"),
    ".inc": (path) => new TextLoader(path),
    ".php": (path) => new TextLoader(path),
    ".js": (path) => new TextLoader(path),
  });
  const formattedDocs = await loader.load();

  const splitter = new RecursiveCharacterTextSplitter({
    chunkSize: 1000,
    chunkOverlap: 200,
  });
  const docs = await splitter.splitDocuments(formattedDocs);
  console.dir(docs, { depth: null });
  const vectorStore = await HNSWLib.fromDocuments(docs, new OpenAIEmbeddings());
  await vectorStore.save(docsPath);
};

const directorySource = process.argv[2];
const directoryOutput = process.argv[3];
if (directorySource && directoryOutput) {
  run(directorySource, directoryOutput);
} else {
  console.log(
    "Please provide a source directory and output directory e.g. \n npm run ingest <filename> <output directory>"
  );
}
