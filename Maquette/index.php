<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulaire</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:400,700" rel="stylesheet">
    <style>
        body {
            font-family: 'Titillium Web', sans-serif;
        }
        .bg-blue {
            background-color: #336699;
        }
        section {
            padding-top: 50px;
            padding-bottom: 50px;
        }
        section h2 {
            text-align: center;
            color: #ffffff;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 3px;
        }
        section h2::after {
            content: ' ';
            display: block;
            width: 80px;
            height: 4px;
            margin: 15px auto;
            background-color: #000;
            opacity: 0.2;
        }
        section > .container > p {
            text-align: center;
            color: #ffffff;
            padding-bottom: 50px;
        }
        .form-control, .form-control:focus {
            background-color: #263971;
            color: #ffffff;
            padding: 12px 25px;
            border: 1px solid transparent;
            box-shadow: none;
        }
        .form-control::placeholder {
            color: #ffffff;
        }
        .btn-webforce {
            background-color: #30bae8;
            color: #ffffff;
            text-transform: uppercase;
            padding: 15px 60px;
            border-bottom: 3px solid #289fc7;
            transition: 0.5s;
        }
        .btn-webforce:hover {
            transform: translateY(3px);
            margin-top: 3px;
            border-bottom: 0px solid transparent;
        }
    </style>
</head>
<body>
    <?php
        if (count($_POST) > 0)
            var_dump($_POST);
    ?>
    <section class="bg-blue">
        <div class="container">
            <h2>Get in touch</h2>
            <p>1600 Pennsylvania Ave NW, Washington, DC 20500, United States of America. Tel: (202) 456-1111</p>
            <div class="row">
                <div class="col-lg-8 offset-2">
                    <form name="form_contact" method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <input id="name" name="name" type="text" class="form-control" placeholder="Your name*">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <input id="email" name="email" type="email" class="form-control" placeholder="Your email*">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-5">
                            <textarea id="message" name="message" class="form-control" rows="6" placeholder="Your message*"></textarea>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-default btn-webforce">Send message</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        $('.btn-webforce').click(function (event) {

            var errors = [];
            var name = $('#name').val();
            var email = $('#email').val();
            var message = $('#message').val();

            $('.form-control').removeClass('is-invalid'); // reset tous les champs
            $('p.invalid-feedback').remove();

            if (name.length < 1) {
                $('#name').addClass('is-invalid');
                errors.push('Erreur sur le name');
                $('#name').after('<p class="invalid-feedback">Le nom n\'est pas valide</p>');
            }

            var regex = /[a-zA-Z0-9._-]{1,}@[a-zA-Z0-9._-]{1,}\.[a-zA-Z]{2,}/g;
            var emailIsValid = email.match(regex);
            if (emailIsValid == null || emailIsValid[0] != email) {
                $('#email').addClass('is-invalid');
                errors.push('Erreur sur l\'email');
                $('#email').after('<p class="invalid-feedback">L\'email n\'est pas valide</p>');
            }

            if (message.length < 10) {
                $('#message').addClass('is-invalid');
                errors.push('Erreur sur le message');
                $('#message').after('<p class="invalid-feedback">Le message n\'est pas valide</p>');
            }

            if (errors.length != 0) { // Si le formulaire n'est pas valide
                event.preventDefault();
            }

        });
    </script>

</body>
</html>
