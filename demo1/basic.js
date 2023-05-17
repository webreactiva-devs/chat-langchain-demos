import { OpenAI } from "langchain/llms/openai";
import { PromptTemplate } from "langchain/prompts";
import { LLMChain } from "langchain/chains";

// Set up OpenAI API credentials
process.env.LANGCHAIN_TRACING = "true";
const openai = new OpenAI({ apiKey: process.env.OPENAI_API_KEY });

// Set up prompt template
const template = "Dame alternativas de nombres de podcasts que hablen de {topic}?";
const prompt = new PromptTemplate({
  template: template,
  inputVariables: ["topic"],
});

// Set up LLMChain
const chain = new LLMChain({ llm: openai, prompt: prompt });

// Call the chain with a topic input
const res = await chain.call({ topic: "cría del cangrejo azul en aguas profundas" });
console.log(res);
