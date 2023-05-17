import readline from "readline";
import path from "path";
import { HNSWLib } from "langchain/vectorstores/hnswlib";
import { OpenAIEmbeddings } from "langchain/embeddings/openai";

const dataFolder = "./demo3/data/vectordb/maquinillo";

async function run(query: string) {
  const directory = path.resolve(process.cwd(), dataFolder);

  const loadedVectorStore = await HNSWLib.load(
    directory,
    new OpenAIEmbeddings()
  );
  const results = await loadedVectorStore.similaritySearch(query, 4);
  // console.dir({ results }, { depth: 5 });
  return results;
}

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout,
  prompt: "¿Qué quieres buscar?> ",
});

rl.prompt();

rl.on("line", async (line) => {
  if (line.toLowerCase() === "exit") {
    console.log("\nExiting!\n");
    process.exit(0);
  } else {
    const response = await run(line);
    console.dir(response, { depth: null });
  }
  rl.prompt();
}).on("close", () => {
  console.log("Exiting!");
  process.exit(0);
});
