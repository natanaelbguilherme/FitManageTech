<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo ao Nosso Serviço</title>
</head>

<body style="font-family: 'Arial', sans-serif; background-color: #f4f4f4; color: #333; padding: 20px;">

    <table
        style="max-width: 600px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        {{-- <tr>
            <td>
                <img src="https://example.com/logo.png" alt="Logo" style="max-width: 100%; height: auto;">
            </td>
        </tr> --}}
        <tr>
            <td style="padding-top: 20px;">
                <h2>Bem-vindo ao Nosso Serviço!</h2>
                <p>Olá {{ $name }},</p>
                <p>Seja bem-vindo à nossa comunidade! Estamos muito felizes em tê-lo como parte da nossa família.
                    Obrigado por escolher o nosso plano de assinatura {{ $description }}.</p>
                <p>Aqui estão alguns benefícios que você pode aproveitar:</p>
                <ul>
                    <li>Cadastro de estudantes: {{ $limit > 0 ? $limit : 'Ilimitado' }}</li>
                    <li>Recursos premium e atualizações regulares.</li>
                    <li>Suporte prioritário da nossa equipe.</li>
                </ul>
                <p>Estamos comprometidos em fornecer a você a melhor experiência possível. Se tiver alguma dúvida ou
                    precisar de assistência, não hesite em entrar em contato conosco. Estamos aqui para ajudar!</p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding-top: 20px;">
                <a href="link de exemplo"
                    style="display: inline-block; padding: 10px 20px; background-color: #3498db; color: #fff; text-decoration: none; border-radius: 5px;">Acesse
                    Seu Painel</a>
            </td>
        </tr>
        <tr>
            <td style="padding-top: 20px; text-align: center;">
                <p>Obrigado mais uma vez por escolher nosso serviço. Estamos ansiosos para vê-lo prosperar conosco.</p>

            </td>
        </tr>
    </table>

</body>

</html>
