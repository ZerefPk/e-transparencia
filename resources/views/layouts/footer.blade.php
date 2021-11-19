<footer class="bg-dark py-5">
  <div class="container text-white">
    <div class="row">
      <div class="col-12 col-md ">
        <div class="text-center">
          <img class="" src="{{ asset(config('application.logo_footer_img')) }}" alt="{{config('application.logo__footer_img_alt')}}" width="150">
          <small class="d-block mb-3 text-muted"> &copy; {{config('application.copyright')}}</small>
        </div>
        
        
      </div>
      
      @foreach ( config('application.footer_menu') as $footer )
      <div class="col-6 col-md">
        <h5>{{$footer['title']}}</h5>
        <ul class="list-unstyled text-small">
          @foreach ($footer['submenu'] as $item)
            <li>
              <a class="text-muted" target="__blank" href="{{$item['url']}}">{{$item['text']}}</a>
            </li>
          @endforeach
          
        </ul>
      </div>
      @endforeach
      
      <div class="col-6 col-md">
        <h5>Políticas</h5>
        <ul class="list-unstyled text-small">
          <li><a class="text-muted" href="{{config('application.police.privacy')}}">Privacidade</a></li>
          <li><a class="text-muted" href="{{config('application.police.terms')}}">Termos</a></li>
          <li><a class="text-muted" href="{{config('application.police.cookies')}}">Cookies</a></li>
          <li>
          <a href="javascript:void(0)" 
            class="js-lcc-settings-toggle">@lang('cookie-consent::texts.alert_settings')
          </a>

          </li>
        </ul>
      </div>
      <div class="col-6 col-md">
        <h5>Contato</h5>
        <ul class="list-unstyled text-small">
          <li class="text-muted" > <i class="fas fa-building "></i> {{config('application.contact.address')}}</li>
          <li class="text-muted" ><i class="fas fa-envelope"></i> {{config('application.contact.mail')}}</li>
          <li class="text-muted" ><i class="fas fa-phone"></i> {{config('application.contact.telephone')}}</li>
        </ul>
      </div>
    </div>
  </div>
    
  </footer>