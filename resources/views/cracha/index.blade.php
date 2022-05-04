<div class="center">
    <img class="center" src="data:image/png;base64, {!! base64_encode(QrCode::size(200)->generate($data)) !!} ">
    </div>
    