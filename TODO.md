# TODO

-   time options [DONE]
-   forgot password [PENDING]
-   make thumbnail on upload [PENDING]
-   di data api karena capacity hanya masuk kepal maka harus diubah ke order rcapacity [bug] [PENDING]

### example order

yang di order adalah event id karena menentukan jam

```json
{
    "newModel": true,
    "alternateEmail": "",
    "creditCardCurrencyId": null,
    "customerName": "A",
    "email": "aji.kamaludin2021@gmail.com",
    "groupName": "",
    "groupBooking": false,
    "groupNoOfMember": 1,
    "isGrabPayPurchase": false,
    "isInstantRedeemAll": false,
    "isSingleCodeForGroup": true,
    "mobileNumber": "",
    "mobilePrefix": "",
    "otherInfo": { "partnerReference": "" },
    "passportNumber": "",
    "paymentMethod": "CREDIT",
    "remarks": "",
    "ticketTypes": [
        {
            "fromResellerId": null,
            "id": 14074,
            "quantity": 1,
            "sellingPrice": null,
            "visitDate": "2023-05-19",
            "index": 0,
            "questionList": [
                { "id": 20965, "answer": "A", "ticketIndex": 0 },
                { "id": 20966, "answer": "A", "ticketIndex": 0 },
                { "id": 20967, "answer": "A", "ticketIndex": 0 },
                { "id": 20968, "answer": "A", "ticketIndex": 0 }
            ],
            "event_id": 837767,
            "packageItems": [],
            "visitDateSettings": []
        }
    ],
    "promoCodeId": null,
    "promotionType": null
}
```
