<?php
{
$base = [
'name' => ['nullable','string','max:120'],
'category' => ['nullable','string','max:120'],
'type' => ['required','in:url,text,wifi,map,whatsapp,pdf,audio,app'],
'format' => ['required','in:png,svg'],
'size' => ['required','integer','min:128','max:2048'],
'error_correction' => ['required','in:L,M,Q,H'],
'foreground' => ['required','regex:/^#([0-9A-Fa-f]{6})$/'],
'background' => ['required','regex:/^#([0-9A-Fa-f]{6})$/'],
'logo' => ['nullable','image','max:2048'],
];


$type = $this->input('type');


$byType = [];
switch ($type) {
case 'url':
case 'app':
$byType = ['url' => ['required','url','max:2000']];
break;
case 'text':
$byType = ['text' => ['required','string','max:4000']];
break;
case 'wifi':
$byType = [
'ssid' => ['required','string','max:200'],
'password' => ['nullable','string','max:200'],
'encryption' => ['required','in:WPA,WEP,nopass'],
'hidden' => ['nullable','boolean'],
];
break;
case 'map':
$byType = [
'lat' => ['required','numeric','between:-90,90'],
'lng' => ['required','numeric','between:-180,180'],
'zoom' => ['nullable','integer','min:1','max:20'],
];
break;
case 'whatsapp':
$byType = [
'phone' => ['required','string','max:20'], // include country code w/o +
'message' => ['nullable','string','max:1000'],
];
break;
case 'pdf':
$byType = [
'file' => ['required','mimes:pdf','max:10240'],
];
break;
case 'audio':
$byType = [
'file' => ['required','mimetypes:audio/mpeg,audio/mp3,audio/x-m4a,audio/wav','max:20480'],
];
break;
}


return array_merge($base, $byType);
}
