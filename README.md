## Allcraft API
----------------------
Printee API base url: http://hoochcreative.com.au/printee/server/index.php

#Orders
----------------------
1. GET ***/orders*** Return all the orders (Don't really need that ?)

2. GET ***/orders?created_at=:date&limit=:limit&offset=:offset*** Return the orders at a specific date 
by the following format (YYYY-MM-DD). Limit is the maximum number of item can be displayed at 
a page. Offset is the first item id will be displayed based on the number of limit (Eg: offset=0,
limit=2 will return list of item from 1,2)

3. GET ***/orders?created_before=:date&limit=:limit&offset=:offset*** Return the orders before the 
provided date by the following format (YYYY-MM-DD). Limit is the maximum number of item can be displayed at
a page. Offset is the first item id will be displayed based on the number of limit (Eg: offset=0,
limit=2 will return list of item from 1,2)

4. GET ***/orders/:id*** Return one order

5. POST ***/orders*** 

6. PUT ***/orders/:id***

