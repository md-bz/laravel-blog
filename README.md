# Blog API – Laravel

An API for managing blog posts, comments, user authentication, and PDF generation, built with Laravel 12 and PHP 8.2.



## Authentication

Uses Laravel Sanctum for token-based API authentication.

### Register

`POST /api/register`

### Login

`POST /api/login`
Returns an authentication token.

### Get Authenticated User

`GET /api/user`
Requires Bearer token.

## Blog Endpoints

### List All Blogs

`GET /api/blog`

### Create Blog

`POST /api/blog`
Requires authentication.

### Get Blog

`GET /api/blog/{blog}`

### Update Blog

`PUT /api/blog/{blog}`
Requires authentication and blog ownership.

### Delete Blog

`DELETE /api/blog/{blog}`
Requires authentication and blog ownership.

### Download Blog as PDF

`GET /blog/{blog}/pdf`

## Comment Endpoints

### Add Comment

`POST /api/comment`

### Update Comment

`PUT /api/comment/{comment}`

### Delete Comment

`DELETE /api/comment/{comment}`

## Notes

* PDF generation handled by `barryvdh/laravel-dompdf`.
* Authentication is required for blog modifications.

