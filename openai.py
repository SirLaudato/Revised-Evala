import openai

openai.api_key = "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"

response = openai.ChatCompletion.create(
    model="gpt-4",
    messages=[{"role": "user", "content": "What version of GPT are you?"}]
)
print(response)
