import sys
import pandas as pd
import pickle
import json

# Step 1 Load the models
with open(public/sales_prediction_models.pkl, rb) as f
    models = pickle.load(f)

# Step 2 Parse input (company name)
company_name = sys.argv[1]

if company_name not in models
    print(json.dumps({error Company not found in trained models}))
    sys.exit(1)

# Step 3 Predict the next sold date
model_data = models[company_name]
model = model_data[model]
min_date = model_data[min_date]
max_date = model_data[max_date]

# Predict the next date
next_day = (max_date - min_date).days + model.coef_[0]
predicted_date = min_date + pd.Timedelta(days=next_day)

# Return prediction
output = {
    Company Name company_name,
    Last Sold Date str(max_date),
    Next Predicted Date str(predicted_date)
}
print(json.dumps(output))
