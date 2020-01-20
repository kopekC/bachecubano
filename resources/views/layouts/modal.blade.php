<!-- Modal -->
<style>
    .modal-content {
        border-radius: 13px
    }

    .modal-body {
        color: #3b3b3b
    }

    .img-thumbnail {
        border-radius: 33px;
        width: 61px;
        height: 61px
    }

    .fab:before {
        position: relative;
        top: 13px
    }

    .smd {
        width: 200px;
        font-size: small;
        text-align: center
    }
</style>
<div class="modal fade" id="BacheModal" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="BacheModalTitle">
                    ¡Se ha publicado su anuncio!
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="BacheModalBody">
                <h6 class="text-center mb-4">Ahora compártelo en tu red social preferida.</h6>
                <div class="icon-container1 d-flex mb-4">
                    <div class="smd">
                        <a class="twitter mb-2" href="{{ route('share', ['network' => 'twitter', 'url' => base64_encode(URL::current()), 'text' => base64_encode($ad->description->title)]) }}" target="popup" rel="noopener noreferrer">
                            <i class="img-thumbnail lni-twitter-filled size-lg" style="color:#4c6ef5;background-color: aliceblue"></i>
                        </a>
                        <a class="twitter mb-2" href="{{ route('share', ['network' => 'twitter', 'url' => base64_encode(URL::current()), 'text' => base64_encode($ad->description->title)]) }}" target="popup" rel="noopener noreferrer">
                            <p>Twitter</p>
                        </a>
                    </div>
                    <div class="smd">
                        <a href="{{ route('share', ['network' => 'facebook', 'url' => base64_encode(URL::current()), 'text' => base64_encode($ad->description->title)]) }}" target="popup" rel="noopener noreferrer">
                            <i class="img-thumbnail lni-facebook-original size-lg" style="color: #3b5998;background-color: #eceff5;"></i>
                        </a>
                        <a href="{{ route('share', ['network' => 'facebook', 'url' => base64_encode(URL::current()), 'text' => base64_encode($ad->description->title)]) }}" target="popup" rel="noopener noreferrer">
                            <p>Facebook</p>
                        </a>
                    </div>
                    <div class="smd"><a href="whatsapp://send?text=Acabo de publicar este anuncio en Bachecubano%20{{ URL::current() }}" target="popup" rel="noopener noreferrer">
                            <i class="img-thumbnail lni-whatsapp size-lg" style="color: #25D366;background-color: #cef5dc;"></i>
                        </a>
                        <a href="whatsapp://send?text=Acabo de publicar este anuncio en Bachecubano%20{{ URL::current() }}" target="popup" rel="noopener noreferrer">
                            <p>Whatsapp</p>
                        </a>
                    </div>
                    <div class="smd">
                        <a href="{{ route('share', ['network' => 'telegram', 'url' => base64_encode(URL::current()), 'text' => base64_encode($ad->description->title)]) }}" target="popup" rel="noopener noreferrer">
                            <i class="img-thumbnail lni-telegram size-lg" style="color: #4c6ef5;background-color: aliceblue"></i>
                        </a>
                        <a href="{{ route('share', ['network' => 'telegram', 'url' => base64_encode(URL::current()), 'text' => base64_encode($ad->description->title)]) }}" target="popup" rel="noopener noreferrer">
                            <p>Telegram</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>