import pathlib
import os
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'
from keras import backend as K
from tensorflow.keras.models import load_model
from silence_tensorflow import silence_tensorflow
silence_tensorflow()
import numpy as np
import pickle
# Load the model and tokenizer
main_directory=pathlib.Path(__file__).resolve().parent.parent
K.clear_session()
model = load_model(str(main_directory)+'/next_words.h5')
tokenizer = pickle.load(open(str(main_directory)+'/token.pkl', 'rb'))


def Predict_Next_Word(model, tokenizer, text):

  sequence = tokenizer.texts_to_sequences([text])
  sequence = np.array(sequence)
  preds = np.argsort(model.predict(sequence))[:, -3:][0]
  predicted_word = []

  for u in preds:
    for key, value in tokenizer.word_index.items():
        if value == u:
            predicted_word.append(key)
            break
  
  return predicted_word
def __main__(text):
    text = text.split()
    prediction_list = []
    for i in range(len(text)-5):
        text_p = text[i:i+6]
        text_p = " ".join(text_p)
        if text_p == "0":
            print("Execution completed.....")
        else:
            try:
                text_p = (" ".join(text_p.split())).split(" ")
                text_p = text_p[-6:]
                predicted_tokens=Predict_Next_Word(model, tokenizer, text_p)
                if(text[i+3].lower() not in predicted_tokens
                    ):
                    predicted_l = []
                    # Get top 2 predictions (index 4 and 3)
                    predicted_l.append([i+3, predicted_tokens[2].lower()])
                    predicted_l.append([i+3, predicted_tokens[1].lower()])
                    prediction_list.append(predicted_l)
                    

            except Exception as e:
                continue
                # print("Error occurred: ",e)
    return prediction_list
