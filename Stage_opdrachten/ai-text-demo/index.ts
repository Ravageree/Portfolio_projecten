import { streamText } from 'ai';
import { google } from '@ai-sdk/google'; // Importeer de Google provider
import 'dotenv/config';

declare const process: {
  stdout: {
    write(text: string): void;
  };
};

async function main() {
  const result = streamText({
    model: google('gemini-3.7-flash'), // Gebruik het gratis Gemini model
    prompt: 'Invent a new holiday and describe its traditions.',
  });

  for await (const textPart of result.textStream) {
    process.stdout.write(textPart);
  }

  console.log();
  console.log('Token usage:', await result.usage);
}

main().catch(console.error);