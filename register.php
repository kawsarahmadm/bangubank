
<?php
require __DIR__ . '/vendor/autoload.php';
use App\{Auth, User, Validation};
use App\Helpers\{Sanitize, FlashMassage};
use App\Storage\StorageFactory;

$sanitize = new Sanitize;
$validation = new Validation;
$config = require 'config/config.php';
$storage = StorageFactory::getStorage($config);



$flashMassage = new FlashMassage();
Auth::isLoggedIn();
$name = '';
$email = '';
$password = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nameInput = $sanitize->sanitize($_POST['name']);
    $emailInput = $_POST['email'];
    $passwordInput = $_POST['password'];

    $name = $validation->nameValidate($nameInput, 'name', 'you must give a name!');
    $email = $validation->emailValidate($emailInput);
    $password = $validation->passwordValidate($passwordInput);


    if ($storage::class === 'App\Storage\FileStorage') {
        $users = $storage->loadData("users.json");
        $allEmail = $storage->getAllByPropertyName($users, "email");

     

        foreach ($allEmail as $existingEmail) {
            if ($email === $existingEmail) {
                $validation->addError('email', "This email already exists!");
            }
        }

        if (!$validation->hasErrors()) {
            $userData = [
                'id' => $storage->generateId("users.json"),
                "name" => $name,
                'email' => $email,
                "password" => password_hash($password, PASSWORD_BCRYPT),
                'account_no' => uniqid('bbank', rand(1000, 9999)),
                'role' => 'customer',
            ];

            if ($storage->saveData($userData, 'users.json')) {
                $flashMassage->flash('success', 'Registered successfully! Please log in now!');
                header("Location: login.php");
                exit();
            } else {
                echo "Registration was not successful";
            }
        }
    }else{
        $users = $storage->loadData("users");
        foreach ($users as $user) {
            if ($user['email'] === $email ) {
                $validation->addError('email', "This email already exists!");
            }
        }
        if (!$validation->hasErrors()) {

            $userData = [
                "name" => $name,
                'email' => $email,
                "password" => password_hash($password, PASSWORD_BCRYPT),
                'account_no' => uniqid('bbank', rand(1000, 9999)),
                'role' => 'customer',
            ];

            if ($storage->saveData($userData)) {
                $flashMassage->flash('success', 'Registered successfully! Please log in now!');
                header("Location: login.php");
                exit();
            } else {
                echo "Registration was not successful";
            }
        }
    }

    
}




?>


<!DOCTYPE html>
<html class="h-full bg-white" lang="en">
<head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>

    <link
      rel="preconnect"
      href="https://fonts.googleapis.com" />
    <link
      rel="preconnect"
      href="https://fonts.gstatic.com"
      crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
      rel="stylesheet" />

    <style>
      * {
        font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont,
          'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans',
          'Helvetica Neue', sans-serif;
      }
    </style>

    <title>Create A New Account</title>
  </head>
<body class="h-full bg-slate-100">
    <div class="flex flex-col justify-center min-h-full py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-6 text-2xl font-bold leading-9 tracking-tight text-center text-gray-900">
                Create A New Account
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
       
            <div class="px-6 py-12 bg-white shadow sm:rounded-lg sm:px-12">
            <?php if ($validation->getError('email')): ?>
                <div class="mt-2 mb-8 bg-red-500 text-sm text-white rounded-lg p-4" role="alert">
                <span class="font-bold"><?=  $validation->getError('email');
                ?></span> 
            </div>    
                        <?php endif; ?>
                <form novalidate class="space-y-6" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                    <div>
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                        <div class="mt-2">
                        <input
                            id="name"
                            name="name"
                            type="text"
                            required
                            value="<?= htmlspecialchars($name) ?>"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6 p-2" />
                        <?php if ($validation->getError('name')): ?>
                            <p class="text-red-500"><?= $validation->getError('name'); ?></p>
                        <?php endif; ?>

                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                        <div class="mt-2">
                            <input
                                id="email"
                                name="email"
                                type="email"
                                autocomplete="email"
                                required
                                value="<?= htmlspecialchars($email) ?>"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6 p-2" />
                            <?php if ($validation->getError('email')): ?>
                                <p class="text-red-500"><?= $validation->getError('email'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        <div class="mt-2">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                required
                                value="<?= htmlspecialchars($password) ?>"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6 p-2" />
                            <?php if ($validation->getError('password')): ?>
                                <p class="text-red-500"><?= $validation->getError('password'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <button
                            type="submit"
                            class="flex w-full justify-center rounded-md bg-emerald-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">
                            Register
                        </button>
                    </div>
                </form>
            </div>

            <p class="mt-10 text-sm text-center text-gray-500">
                Already a customer?
                <a href="./login.php" class="font-semibold leading-6 text-emerald-600 hover:text-emerald-500">
                    Sign-in
                </a>
            </p>
        </div>
    </div>
</body>
</html>
