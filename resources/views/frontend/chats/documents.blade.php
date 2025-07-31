
                                <div class="row"> 
                                    @if( isset($chatDocs) && !empty($chatDocs))
                                        @foreach( $chatDocs as $ch)
                                    <div class="col-12 col-lg-6">
                                        <div class="fileBody_inner d-flex justify-content-between align-items-center">
                                            <div class="fileResult_inner">
                                                <img src="{{$ch['doc_path_toshow']['image']}}" alt="pdf">
                                                <div class="folderName">
                                                    <a class="view-file" href="#">
                                                        <h6 class="primary m-0">{{$ch['doc_path_toshow']['title']}}</h6>
                                                    </a>
                                                    <p class="m-0">{{$ch['created_time']}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   @endforeach
                                @endif
                                </div>            
                 