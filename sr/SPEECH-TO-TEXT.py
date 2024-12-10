from vosk import Model, KaldiRecognizer
import pyaudio
import json

# Load Vosk model
model = Model(r"C:\Users\Alivio_Family\PycharmProjects\BEDTE\vosk-model-tl-ph-generic-0.6")
recognizer = KaldiRecognizer(model, 16000)

# Initialize PyAudio
mic = pyaudio.PyAudio()
stream = mic.open(format=pyaudio.paInt16, channels=1, rate=16000, input=True, frames_per_buffer=8192)
stream.start_stream()

print("Listening... Press Ctrl+C to stop.")

try:
    while True:
        data = stream.read(4096, exception_on_overflow=False)
        if recognizer.AcceptWaveform(data):
            # Parse and print the transcription
            result = recognizer.Result()
            result_dict = json.loads(result)  # Convert JSON string to dictionary
            print(f"Recognized Text: {result_dict.get('text', '')}")
except KeyboardInterrupt:
    print("\nStopping...")
except Exception as e:
    print(f"An error occurred: {e}")
finally:
    # Close resources
    stream.stop_stream()
    stream.close()
    mic.terminate()

