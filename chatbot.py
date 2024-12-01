import openai

# Set your OpenAI API key
openai.api_key = "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"

# Example usage with the new API
response = openai.ChatCompletion.create(
    model="gpt-3.5-turbo",
    messages=[
        {"role": "system", "content": "You are a helpful assistant."},
        {"role": "user", "content": "Hello!"},
    ],
)

# Print the assistant's response
print(response["choices"][0]["message"]["content"])
