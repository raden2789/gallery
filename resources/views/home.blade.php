@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>GALLERY PHOTO</div>
                        <div>

                            <form class="form-inline">
                            <select class="form-control" onchange="sort_by(this.value)">
                                <option value="terbaru" {{((Request::query('sort_by') && Request::query('sort_by')=='terbaru' ) || !Request::query('sort_by') )?'selected':''}}>Terbaru</option>
                                <option value="terakhir" {{(Request::query('sort_by') && Request::query('sort_by')=='terakhir')?'selected':''}}>Terakhir</option>
                            </select>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-3">
                          <p>Di Filter Oleh Kategori</p>
                          <div class="list-group">
                              <a href="javascript:filter_image('')" class="list-group-item list-group-item-action {{(!Request::query('category'))?'active':''}}">Semua</a>
                              <a href="javascript:filter_image('twopiece')" class="list-group-item list-group-item-action {{(Request::query('category')=='twopiece')?'active':''}}">Two Piece</a>
                              <a href="javascript:filter_image('fairytape')" class="list-group-item list-group-item-action {{(Request::query('category')=='fairytape')?'active':''}}">Fairy Tape</a>
                              <a href="javascript:filter_image('jujurkasian')" class="list-group-item list-group-item-action {{(Request::query('category')=='jujurkasian')?'active':''}}">Jujur Kasian</a>
                          </div>
                        </div>
                        <div class="col-md-9">

                            <div class="row">
                                  <div class="col-md-12">
                                    @if($errors->any())
                                    @foreach($errors->all() as $error)
                                    
                                    <div class="alert alert-danger">
                                      <strong>Error!</strong>  {{$error}}
                                    </div>
                                    @endforeach
                                  @endif

                                    <button data-toggle="collapse"  class="btn btn-success" data-target="#demo">Tambah Foto</button>

                                    <div id="demo" class="collapse">

                                        <form action="{{route('image-store')}}" method="post" id="image_upload_form" enctype="multipart/form-data">
                                          @csrf
                                            <div class="form-group">
                                              <label for="caption">Deskripsi Foto</label>
                                              <input type="text" name="caption" class="form-control" placeholder="Masukkan Keterangan" id="caption">
                                            </div>
                                            <div class="form-group">
                                                <label for="category">Pilih Daftar Album</label>
                                                <select name="category" class="form-control" id="category">
                                                  <option value="">Pilih Kategori</option>
                                                  <option value="twopiece">Two Piece</option>
                                                  <option value="fairytape">Fairy Tape</option>
                                                  <option value="jujurkasian">Jujur Kasian</option>
                                                </select>
                                              </div>
                                              <div class="form-group">
                                                  <label class="control-label">Upload Foto</label>
                                                  <div class="preview-zone hidden">
                                                    <div class="box box-solid">
                                                      <div class="box-header with-border">
                                                        <div><b>Preview</b></div>
                                                        <div class="box-tools pull-right">
                                                          <button type="button" class="btn btn-danger btn-xs remove-preview">
                                                            <i class="fa fa-times"></i> Batalkan
                                                          </button>
                                                        </div>
                                                      </div>
                                                      <div class="box-body"></div>
                                                    </div>
                                                  </div>
                                                  <div class="dropzone-wrapper">
                                                    <div class="dropzone-desc">
                                                      <i class="glyphicon glyphicon-download-alt"></i>
                                                      <p>Choose an image file or drag it here.</p>
                                                    </div>
                                                    <input type="file" name="image" class="dropzone">
                                                  </div>

                                                  <div id="image_error"></div>
                                                </div>

                                            <button type="submit" class="btn btn-primary">Kirim</button>
                                          </form>


                                      </div>
                                  </div>

                          <div class="col-md-12 mt-4">
                              <div class="row">

                                @if(count($images))

                                  @foreach($images as $image)
                                    <div class="col-md-3 mb-4">
                                          <a href="#">
                                              <img src="{{asset('user_images/thumb/'.$image->image)}}" height="100%" width="100%">
                                          </a> 
                                    </div>
                                  @endforeach

                                  @else
                                    <div class="col-md-12">
                                      <p>Gambar Tidak di Temukan</p>
                                    </div>
                                @endif

                                @if(count($images))
                                  <div class="col-md-12">
                                    {{$images->appends(Request::query())->links()}}
                                  </div>
                                @endif


                              </div>

                           </div>
                       </div>

                     </div>

                   </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@section('js')
<script type="text/javascript">

  var query={};

  @if(Request::query('category'))
  Object.assign(query,{'category':"{{Request::query('category')}}"});
  @endif
  
  @if(Request::query('sort_by'))
    Object.assign(query,{'sort_by':"{{Request::query('sort_by')}}"});
  @endif

  function filter_image(value){
    Object.assign(query,{'category':value});
    window.location.href="{{route('home')}}"+'?'+$.param(query);
  }

  function sort_by(value){
    Object.assign(query,{'sort_by':value});
    window.location.href="{{route('home')}}"+'?'+$.param(query);
  }



  $("#image_upload_form").validate({
  rules: {
    caption: {
      required: true,
      maxlength: 255
    },
    category: {
      required: true
    },
    image:{
      required:true,
      extension:"png|jpeg|jpg|bmp"
    }

  },
  messages: {
    caption: {
      required: "Mohon untuk Masukan Keterangan Foto.",
      maxlength: "Max. 255 characters allowed."
    },
    category: {
      required: "Mohon pilih Kategori Foto.",
    },
    image: {
      required: "Upload Foto.",
      extension: "Hanya jpeg,jpg,png,bmp allowed",
    }
  },
    errorPlacement:function(error,element){
      if(element.attr('name')=="image"){
        error.insertAfter("#image_error");
      }else{
        error.insertAfter(element);
      }
    }
  });



    function readFile(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {

      var validImageType=['image/png','image/bmp','image/jpeg','image/jpg'];

      if(!validImageType.includes(input.files[0]['type'])){
        var htmlPreview =
        '<p>Image preview not available</p>' +
        '<p>' + input.files[0].name + '</p>';
      }else{
        var htmlPreview =
        '<img width="70%" height="300" src="' + e.target.result + '" />' +
        '<p>' + input.files[0].name + '</p>';
      }
      
  
      var wrapperZone = $(input).parent();
      var previewZone = $(input).parent().parent().find('.preview-zone');
      var boxZone = $(input).parent().parent().find('.preview-zone').find('.box').find('.box-body');

      wrapperZone.removeClass('dragover');
      previewZone.removeClass('hidden');
      boxZone.empty();
      boxZone.append(htmlPreview);
    };

    reader.readAsDataURL(input.files[0]);
  }
}

function reset(e) {
  e.wrap('<form>').closest('form').get(0).reset();
  e.unwrap();
}

$(".dropzone").change(function() {
  readFile(this);
});

$('.dropzone-wrapper').on('dragover', function(e) {
  e.preventDefault();
  e.stopPropagation();
  $(this).addClass('dragover');
});

$('.dropzone-wrapper').on('dragleave', function(e) {
  e.preventDefault();
  e.stopPropagation();
  $(this).removeClass('dragover');
});

$('.remove-preview').on('click', function() {
  var boxZone = $(this).parents('.preview-zone').find('.box-body');
  var previewZone = $(this).parents('.preview-zone');
  var dropzone = $(this).parents('.form-group').find('.dropzone');
  boxZone.empty();
  previewZone.addClass('hidden');
  reset(dropzone);
});

</script>
@endsection