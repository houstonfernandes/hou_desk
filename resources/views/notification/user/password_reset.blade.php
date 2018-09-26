@component('mail::message')
    	{{-- Greeting --}}
    @if (! empty($greeting))
    	# {{ $greeting }}
    @else
    	@if ($level == 'error')
    		# Whoops!
        @else
        	# Hello!
        @endif
    @endif
    
    {{-- Intro Lines --}}
    @foreach ($introLines as $line)
    	{{ $line }}
    
    @endforeach
    
    {{-- Action Button --}}
    @if (isset($actionText))
        <?php
            switch ($level) {
                case 'success':
                    $color = 'green';
                    break;
                case 'error':
                    $color = 'red';
                    break;
                default:
                    $color = 'blue';
            }
        ?>
        @component('mail::button', ['url' => $actionUrl, 'color' => $color])
        	{{ $actionText }}
        @endcomponent
    @endif
    
    {{-- Outro Lines --}}
    @foreach ($outroLines as $line)
    	{{ $line }}
    
    @endforeach
    
    <!-- Salutation -->
    @if (! empty($salutation))
    	{{ $salutation }}
    @else
    	Atenciosamente,<br>{{ config('app.name') }}
    @endif
    
    <!-- Subcopy -->
    @if (isset($actionText))
        @component('mail::subcopy')
        Se tiver algum problema ao clicar em: "{{ $actionText }}", copie e cole a url abaixo em seu navegador: [{{ $actionUrl }}]({{ $actionUrl }})
        @endcomponent
    @endif
@endcomponent
