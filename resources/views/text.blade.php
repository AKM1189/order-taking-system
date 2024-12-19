<div>
     @php
        $token = generateUniqueToken(32, '<Table-Name>','<Column-Name>');
     @endphp

        {{ $token }}
 </div>