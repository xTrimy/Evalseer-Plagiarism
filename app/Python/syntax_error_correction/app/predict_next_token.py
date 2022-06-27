import pickle
import numpy as np
from silence_tensorflow import silence_tensorflow
from tensorflow.keras.models import load_model
from keras import backend as K
import pathlib
import os
from datetime import datetime
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'
silence_tensorflow()
# Load the model and tokenizer
main_directory = pathlib.Path(__file__).resolve().parent.parent
K.clear_session()
model = load_model(str(main_directory)+'/next_words.h5')
tokenizer = pickle.load(open(str(main_directory)+'/token.pkl', 'rb'))


def Predict_Next_Word(model, tokenizer, text):
  sequence = tokenizer.texts_to_sequences([text])
  sequence = np.array(sequence)
  predict = model.predict(sequence)
  preds = np.argsort(predict)[:, -5:][0]
  predicted_tokens = [tokenizer.index_word[i] for i in preds]
  predict = np.around(predict, decimals=5)
  all_prediected_tokens = [predicted_tokens, np.sort(predict)[:, -5:][0], text]
  threshold = 0.5
  weights = []
  tokens = []
  for i in range(len(all_prediected_tokens[1])):
    if(all_prediected_tokens[1][i] >= threshold):
        weights.append(all_prediected_tokens[1][i])
        tokens.append(all_prediected_tokens[0][i])
  all_prediected_tokens[1] = weights
  all_prediected_tokens[0] = tokens

  return all_prediected_tokens


def __main__(text):
    text = text.split()
    prediction_list = []
    all_predictions = []
    for i in range(len(text)-5):
        text_p = text[i:i+6]
        text_p = " ".join(text_p)
        if text_p == "0":
            print("Execution completed.....")
        else:
            try:
                text_p = (" ".join(text_p.split())).split(" ")
                text_p = text_p[-6:]

                pred = Predict_Next_Word(model, tokenizer, text_p)
                predicted_tokens = pred[0]
                if(text[i+3].lower() not in predicted_tokens
                   ):
                    all_predictions.append([pred, i+3])

            except Exception as e:
                continue
                # print("Error occurred: ",e)

    # filter all_predictions where [1] is not empty and [0] is not empty
    preds = [x for x in all_predictions if x[0][0] != []]
    # print("Predictions: ", preds)
    preds.sort(key=lambda x: np.max(x[0][1]), reverse=True)
    all_predictions = preds
    # f = open(str(main_directory)+"/log/pred.log", "a")
    # f.write("["+str(datetime.now())+"]"+"\n")
    # f.write("Found solution: "+str(all_predictions)+"\n\n")
    # f.close()
    for i in all_predictions:
        # print("========================= START ===============================")
        # print(i)
        # print("========================== END ================================")
        predicted_tokens = i[0][0]
        predicted_l = []
        # reverse the predicted tokens
        predicted_tokens = predicted_tokens[::-1]
        for j in predicted_tokens:
            predicted_l.append([i[1], j.lower()])
        prediction_list.append(predicted_l)
    return prediction_list
