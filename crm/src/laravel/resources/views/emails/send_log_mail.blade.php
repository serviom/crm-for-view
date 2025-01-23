@component('mail::message')
    <p>Привіт!</p>
    <p>Вам надіслали лог про помилку:</p>
    <table>
        <tr>
            <td>Помилка:</td>
            <td>{{ $title }}</td>
        </tr>
        <tr>
            <td>Посилання:</td>
            <td><a href="{{ $link }}">{{ $link }}</a></td>
        </tr>
        <tr>
            <td>Нотатка:</td>
            <td>{{ $description }}</td>
        </tr>
    </table>
@endcomponent
