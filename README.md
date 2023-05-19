# Chat-Langchain-Demos

Repositorio de ejemplos para el uso de Langchain, una biblioteca para interactuar con el API de OpenAI utilizando cadenas de LLM (Language Model) y plantillas de prompts.

[Masterclass en Web Reactiva](https://www.webreactiva.com/cursos/masterclass/como-crear-aplicaciones-con-inteligencia-artificial-con-langchain-y-openai)

![image](https://github.com/webreactiva-devs/chat-langchain-demos/assets/1122071/ae2ec61f-2f6b-42b2-8b2e-584f703f9b93)


## Demostraciones

### Demo 1: Básico

El primer ejemplo se centra en la creación y uso de una simple cadena de LLM (LLMChain) para generar alternativas de nombres de podcasts basados en un tema dado【9†source】. 

Aquí está una versión simplificada del código:

```javascript
import { OpenAI, PromptTemplate, LLMChain } from "langchain";

// Configura las credenciales de la API de OpenAI
const openai = new OpenAI({ apiKey: "YOUR_OPENAI_API_KEY" }); 

// Configura la plantilla de prompt
const template = "Dame alternativas de nombres de podcasts que hablen de {topic}?";
const prompt = new PromptTemplate({ template: template, inputVariables: ["topic"] }); 

// Configura la LLMChain
const chain = new LLMChain({ llm: openai, prompt: prompt }); 

// Llama a la cadena con un tema de entrada
const res = await chain.call({ topic: "cría del cangrejo azul en aguas profundas" });  
console.log(res);
```

### Demo 2: Memoria

La demostración 2 de chat-langchain-demos muestra cómo implementar un chatbot con memoria utilizando LangChain.js. Este chatbot es capaz de mantener una conversación en el tiempo, recordando las interacciones previas para proporcionar respuestas más contextuales y precisas.


Aquí está una versión simplificada del código:

```javascript
 // Ejemplo simplificado
  const chat = new ChatOpenAI({ streaming: false, maxRetries: 1 });
  const lcChatMessageHistory = new ChatMessageHistory(mapStoredMessagesToChatMessages(messages));
  const memory = new BufferMemory({ chatHistory: lcChatMessageHistory, returnMessages: true, memoryKey: "history" });
  const chatPrompt = ChatPromptTemplate.fromPromptMessages([
    SystemMessagePromptTemplate.fromTemplate("Eres un asistente amigable que sabe mucho de historia. Responde SIEMPRE en español."),
    new MessagesPlaceholder("history"),
    HumanMessagePromptTemplate.fromTemplate("{input}"),
  ]);
  const chain = new ConversationChain({ memory: memory, llm: chat, prompt: chatPrompt });
  const res = await chain.call({ input: prompt });

```

### Demo 3: Tus propios datos

Tenemos dos archivos principales en este proyecto, `ingest-code.js` y `chat-database.js`.

`ingest-code.js`

Este fichero es responsable de la ingesta de los documentos. Carga documentos desde un directorio especificado y los guarda en un vectorstore usando la biblioteca HNSWLib. Los documentos pueden tener distintos formatos, como `.json`, `.inc`, `.php`, y `.js`. Los documentos son entonces divididos en chunks, transformados en vectores y guardados en el vectorstore.

`chat-database.js`

Este archivo contiene la lógica para interactuar con el usuario a través de la línea de comando y buscar las respuestas a las preguntas del usuario en el vectorstore. Utiliza una cadena de búsqueda y un modelo de OpenAI para encontrar la respuesta más relevante a la pregunta del usuario. Actualmente, el sistema admite los modelos `gpt-3.5-turbo` y `gpt-4`.

#### Uso

`ingest-code.js`

Para usar este script, ejecuta el siguiente comando en tu terminal, reemplazando `<source_directory>` y `<output_directory>` con tus rutas específicas.

```bash
npm run ingest-code <source_directory> <output_directory>
```

`database.js`

Para iniciar una sesión de chat, ejecuta el archivo `chat-database.js`. El programa te hará una pregunta y puedes responder escribiendo en la línea de comando.

```bash
node database.js
```

Si en cualquier momento deseas salir de la sesión de chat, simplemente escribe `exit` en la línea de comando.

## Dependencias

Este proyecto depende de varias bibliotecas, incluyendo:

- `langchain/vectorstores`
- `langchain/embeddings`
- `langchain/text_splitter`
- `langchain/document_loaders`
- `langchain/chains`
- `langchain/llms/openai`
- `langchain/callbacks`
- `langchain/chat_models/openai`


## Acerca de LangChain.js

`LangChain.js` es una biblioteca diseñada para construir aplicaciones con LLM a través de la componibilidad. Los LLM están emergiendo como una tecnología transformadora que permite a los desarrolladores crear aplicaciones que antes no podían. Sin embargo, usar estos LLM de forma aislada a menudo no es suficiente para crear una aplicación verdaderamente poderosa. El verdadero poder proviene cuando se pueden combinar con otras fuentes de cálculo o conocimiento.

La biblioteca `LangChain.js` está diseñada para ayudar en el desarrollo de estos tipos de aplicaciones. Esta biblioteca se construyó para integrarse de la manera más fluida posible con el paquete Python de LangChain. Esto significa que todos los objetos (prompts, LLM, cadenas, etc.) están diseñados de tal manera que pueden ser serializados y compartidos entre lenguajes. El LangChainHub es un lugar central para las versiones serializadas de estos prompts, cadenas y agentes【37†source】【38†source】【39†source】.


### Instalación de la biblioteca LangChain.js

Para instalar la biblioteca `LangChain.js` en tu proyecto, puedes usar el gestor de paquetes Yarn con el siguiente comando:

```bash
yarn add langchain
```

Luego, en tu código, puedes importar `OpenAI` desde `langchain/llms` de la siguiente manera:

```javascript
import { OpenAI } from 'langchain/llms';
```

Para más detalles y documentación completa de prompts, cadenas, agentes y más, puedes consultar [aquí](https://hwchase17.github.io).


### OpenAI

Tienes que generar una API KEY válida y configurarla como varible de entorno en `OPENAI_API_KEY`.
