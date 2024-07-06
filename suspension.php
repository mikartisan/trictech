<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Suspended</title>

    <!-- Favicon  -->
    <!-- <link rel="shortcut icon" href="./images/favicon/favicon-32x32.png"> -->
    <!-- Tailwindcss -->
    <link rel="stylesheet" href="dist/output.css">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Tailwind Elements -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />

    <!-- Notification and Modal -->
    <script src="./dist/tata.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- flowbite -->
    <script src="./dist/flowbite.js"></script>
</style>
</head>
<body>
    <div class="lg:px-24 lg:py-24 md:py-20 md:px-44 px-4 py-24 items-center flex justify-center flex-col-reverse lg:flex-row md:gap-28 gap-16">
        <div class="xl:pt-24 w-full xl:w-1/2 relative pb-12 lg:pb-0">
            <div class="relative">
                <div class="absolute">
                    <div class="">
                        <h1 class="my-2 text-gray-800 font-bold text-2xl">
                            Your Account is Temporarily Suspended
                        </h1>
                        <p class="my-2 text-gray-800">
                            We apologize for the inconvenience, but your account is currently suspended. 
                            Please contact support at [trictoda@gmail.com] for further information.
                        </p>
                        <a href="auth/login.php">
                            <button class="sm:w-full lg:w-auto my-2 border rounded md py-4 px-8 text-center bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-700 focus:ring-opacity-50">Back</button>
                        </a>
                    </div>
                </div>
                <div>
                    <img src="images/suspended.png" />
                </div>
            </div>
        </div>
        <div>
            <img src="https://i.ibb.co/ck1SGFJ/Group.png" />
        </div>
    </div>
</body>
</html>