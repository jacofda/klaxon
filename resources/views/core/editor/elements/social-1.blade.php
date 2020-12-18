<table class="main" width="100%" cellspacing="0" cellpadding="0" border="0" data-types="social-content,background,padding" data-last-type="social-content" align="center" style="background-color:#FFFFFF;">
    <tbody>
        <tr>
            <td class="element-content social-content" style="padding:20px 50px;text-align:center">

                @php
                    $social = Jacofda\Klaxon\Models\Setting::where('model', 'Social')->first();
                @endphp

                @if($social && $social->areFieldsFilled())
                    @foreach($social->fields as $key => $value)

                        @if($value != '')
                            <a href="{{$value}}" style="border: none;display: inline-block;margin-top: 10px;" class="instagram">
                                <img border="0" src="{{asset('editor/assets/images/social-icons/'.$key.'-01.png')}}" width="32">
                            </a>
                        @endif

                    @endforeach
                @else

                    <a href="#insta3" style="border: none;display: inline-block;margin-top: 10px;" class="instagram">
                        <img border="0" src="{{asset('editor/assets/images/social-icons/instagram-01.png')}}" width="32">
                    </a>
                    <a href="#" style="border: none;display: inline-block;margin-top: 10px;" class="pinterest">
                        <img border="0" src="{{asset('editor/assets/images/social-icons/pinterest-01.png')}}" width="32">
                    </a>
                    <a href="#" style="border: none;display: inline-block;margin-top: 10px;" class="facebook">
                        <img border="0" src="{{asset('editor/assets/images/social-icons/facebook-01.png')}}" width="32">
                    </a>
                    <a href="#" style="border: none;display: inline-block;margin-top: 10px;" class="twitter">
                        <img border="0" src="{{asset('editor/assets/images/social-icons/twitter-01.png')}}" width="32">
                    </a>
                    <a href="#" style="border: none;display: inline-block;margin-top: 10px;" class="linkedin">
                        <img border="0" src="{{asset('editor/assets/images/social-icons/linkedin-01.png')}}" width="32">
                    </a>
                    <a href="#" style="border: none;display: inline-block;margin-top: 10px;" class="youtube">
                        <img border="0" src="{{asset('editor/assets/images/social-icons/youtube-01.png')}}" width="32">
                    </a>

                @endif
            </td>
        </tr>
    </tbody>
</table>