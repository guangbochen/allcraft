
<h1>Allcraft Printee API</h1>

<h3>3.0 Messages & Subscribers (GET)</h3>
<p> /Message : get all the push messages and its assigned users </p>
<p> /Message/id : get a specific push message by id </p>

<h4>3.1 Push Broadcast messages (POST)</h4>
<p>/push : Printee server expected to receives json data with the following parameters</p>
        json_data 
        {
          "username" : "foo",
          "is_creator" : true,
          "number_of_orders": "3",
          "subscribers": ["bill", "jack", "lucy"]
        }
        
        # Description:
        username: username of the order generator,
        is_creator: true/false or 1/0  (false when user updates the order - need more discussion),
        number_of_orders: total number of orders has been generated,
        subscribers: assigned users 
<h4>3.2 Broadcast messages Client</h4>
<blockquote>
<p> Client Demo: http://hoochcreative.com.au/client </p>
<p>     - in order to receives a broadcast message you have to push a broadcast message and the method is described as above </p>
</blockquote>
        JS Client Code:
        <html>
        <head>
            <script src=http://cdn.pubnub.com/pubnub.min.js></script>
            <script>
                var pubnub = PUBNUB.init({
                subscribe_key : 'sub-c-077f7902-66ad-11e3-b1d4-02ee2ddab7fe',
                publish_key: 'pub-c-8021207d-c906-4f21-ac84-7d5773c9255b'
                });
        
                pubnub.subscribe({ 
                    channel : 'printee_notification',
                    message: function(message) { 
                            //doing things when receives the message
                            alert(message);
                            console.log(message);
                            }
                });
            </script>
        </head>
        <body>
        </body>
        </html>
<p> and you will receives the json that contains the broadcast messages and its subscribers(assigned user for the order)</p>
        [
            {
                "id": "19",
                "username": "foo",
                "is_creator": "1",
                "description": "3 new orders has been created",
                "created_at": "2013-12-18 14:56:58",
                "ownSubscribers": [
                    {
                        "id": "55",
                        "message_id": "19",
                        "assigned_user": "bill"
                    },
                    {
                        "id": "56",
                        "message_id": "19",
                        "assigned_user": "jack"
                    },
                    {
                        "id": "57",
                        "message_id": "19",
                        "assigned_user": "lucy"
                    }
                ]
            }
        ]
