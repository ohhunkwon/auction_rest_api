# PHP REST API for Db Project

1. BIDS

- create.php:
Request: e.g.
{
    "userID": "1",
    "itemID": "11",
    "amount": "1000",
    "bidID": "30",
    "createdAt": "2021-10-22 07:01:07"
}

Reponse: e.g.
{
    "message": "Bid amount is too Low!"
}

- read.php
Request: e.g.
http://localhost:8888/auction_rest_api/api/bids/read.php?itemID=11

Response: e.g.
{
    "data": [
        {
            "itemID": "11",
            "latestBidID": "1",
            "createdAt": "2021-10-22 08:02:18",
            "userID": "3",
            "priceOfLatestBid": "770"
        }
    ]
}

2. LISTING

- create.php
Request: e.g.
{
    "title": "Nike shoes",
    "description": "asdfnsdasdaa adjkva vv",
    "category": "Sports",
    "startDateTime": "2021-10-23 10:00:00",
    "endDateTime": "2021-10-29 08:00:30",
    "startingPrice": "15",
    "reservePrice": "20",
    "image": "image.jpg",
    "userID": "3",
    "highestPrice": "20"
}

Response: e.g.
{
    "message": "Listing Created"
}

- has_auction_ended.php
Request: e.g.
http://localhost:8888/auction_rest_api/api/listing/has_auction_ended.php?itemID=11

Response: e.g.
"true"

- read_category.php
Request: e.g. 
http://localhost:8888/auction_rest_api/api/listing/read_category.php?category=Electronics

Response: e.g.
{
    "data": [
        {
            "itemID": "13",
            "title": "Macbook Pro 2018",
            "description": "adsafvs da sa",
            "category": "Electronics",
            "userID": "4",
            "seller": "David",
            "startDateTime": "2021-10-22 07:02:29",
            "endDateTime": "2021-10-29 08:02:30",
            "startingPrice": "700",
            "reservePrice": "850",
            "latestBidID": "3",
            "image": "image.jpeg"
        },
        {
            "itemID": "11",
            "title": "42 inch TV",
            "description": "adasdfewfwe",
            "category": "Electronics",
            "userID": "1",
            "seller": "John",
            "startDateTime": "2021-10-22 07:01:07",
            "endDateTime": "2021-10-24 08:01:08",
            "startingPrice": "400",
            "reservePrice": "500",
            "latestBidID": "1",
            "image": "image.png"
        }
    ]
}

- read_item.php
Req: e.g.
http://localhost:8888/auction_rest_api/api/listing/read_search.php?input=ar

Res: e.g.
{
    "data": [
        {
            "itemID": "11",
            "title": "42 inch TV",
            "description": "adasdfewfwe",
            "category": "Electronics",
            "userID": "1",
            "seller": "John",
            "startDateTime": "2021-10-22 07:01:07",
            "endDateTime": "2021-10-24 08:01:08",
            "startingPrice": "400",
            "reservePrice": "500",
            "latestBidID": "1",
            "image": "image.png"
        }
    ]
}

- read_search.php
Req: e.g.
http://localhost:8888/auction_rest_api/api/listing/read_item.php?itemID=11

Res: e.g.
{
    "data": [
        {
            "itemID": "12",
            "title": "Parka Coat",
            "description": "savasd sdf dsa fs s",
            "category": "Fashion",
            "userID": "2",
            "startDateTime": "2021-10-22 07:02:29",
            "endDateTime": "2021-10-28 08:02:30",
            "startingPrice": "50",
            "reservePrice": "60",
            "latestBidID": "2",
            "image": "image.png",
            "search_input": null
        },
        {
            "itemID": "16",
            "title": "Rare £1 Coin",
            "description": "adsadssda",
            "category": "Collectibles",
            "userID": "1",
            "startDateTime": "2021-10-25 10:00:00",
            "endDateTime": "2021-11-10 10:00:00",
            "startingPrice": "300",
            "reservePrice": "450",
            "latestBidID": "5",
            "image": "image.jpg",
            "search_input": null
        }
    ]
}

- read.php
Req: e.g.
http://localhost:8888/auction_rest_api/api/listing/read.php

Res: e.g.
{
    "data": [
        {
            "itemID": "18",
            "title": "Nike shoes",
            "description": "asdfnsdasdaa adjkva vv",
            "category": "Sports",
            "userID": "3",
            "seller": "Michael",
            "startDateTime": "2021-10-23 10:00:00",
            "endDateTime": "2021-10-29 08:00:30",
            "startingPrice": "15",
            "reservePrice": "20",
            "latestBidID": null,
            "image": "image.jpg"
        },
        {
            "itemID": "17",
            "title": "Squash Racket",
            "description": "asdfnnja jkva vv",
            "category": "Sports",
            "userID": "2",
            "seller": "Jane",
            "startDateTime": "2021-10-23 10:00:00",
            "endDateTime": "2022-10-13 08:00:30",
            "startingPrice": "15",
            "reservePrice": "20",
            "latestBidID": null,
            "image": "image.jpg"
        },
        {
            "itemID": "16",
            "title": "Rare £1 Coin",
            "description": "adsadssda",
            "category": "Collectibles",
            "userID": "1",
            "seller": "John",
            "startDateTime": "2021-10-25 10:00:00",
            "endDateTime": "2021-11-10 10:00:00",
            "startingPrice": "300",
            "reservePrice": "450",
            "latestBidID": "5",
            "image": "image.jpg"
        },
        {
            "itemID": "14",
            "title": "Tennis Racket",
            "description": "asdfnnja jkva vv",
            "category": "Sports",
            "userID": "2",
            "seller": "Jane",
            "startDateTime": "2021-10-23 10:00:00",
            "endDateTime": "2021-10-29 08:00:30",
            "startingPrice": "15",
            "reservePrice": "20",
            "latestBidID": "4",
            "image": "image.jpg"
        }, 
        ... etc etc (shows all items everywhere)
    ]
}

3. Watchlist

- create.php
Req: e.g.
{
    "itemID": "11",
    "userID": "3"
}

Res: e.g.
{
    "message": "Watchlist Item Added"
}

- read.php
Req: e.g.
http://localhost:8888/auction_rest_api/api/watchlist/read.php?userID=1

Res: e.g.
{
    "data": [
        {
            "itemID": "11",
            "userID": "1"
        }
    ]
}

4. User

- read.php
e.g. http://localhost:8888/auction_rest_api/api/user/read.php?userID=2
response: {
    "data": [
        {
            "firstName": "Jane",
            "lastName": "Doe",
            "email": "janedoe@gmail.com",
            "role": "Seller",
            "createdAt": "2021-10-22 07:47:02",
            "updatedAt": "2021-10-22 06:44:34"
        }
    ]
}

- register.php
e.g. {
    "email": "ohhunkwon@hotmail",
    "password": "12345",
    "confirmPassword": "12345",
    "firstName": "Ohhun",
    "lastName": "Kwon",
    "role": "Seller",
    "createdAt": "2021-11-22 07:47:02",
    "updatedAt": "2021-11-22 07:47:02"
}
response: {
    "message": "User Created"
}