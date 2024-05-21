<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>محصول جدید</title>
</head>
<body>
    <h3>
        محصول جدیدی با مشخصات زیر اضافه شد
    </h3>
    <p>نام : {{$product->name}}</p>
    <p>قیمت : {{$product->price}}</p>
    <p>تعداد : {{$product->stock}}</p>
</body>
</html>
