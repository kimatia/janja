<div id="textbox" style="margin-left: 15px;margin-right: 15px;">

<form>
<div class="row">
<div class="col-md-7">
<textarea class="form-control" type="text" id="text"   placeholder="enter comment" ></textarea>
</div>
<div class="col-md-5">
<button class="form-control" type="submit" name="btnsave" value="send"  onclick="getText()" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> &nbsp; comment
        </button>
        </div>
</form>
</div>
<section id="works" class="section">
<div class="container clearfix">

    <div class="row" >
        <div class="span12">
            <div id="portfolio-wrap">
                <!-- portfolio item -->
                <div class="portfolio-item grid print photography">
                    <div class="portfolio" >
                        <a href="upload/<?php echo $row['userPic']; ?>" data-pretty="prettyPhoto[gallery1]" class="portfolio-image">
                        <img src="upload/<?php echo $row['userPic']; ?>" class="img-rounded"  />
                        <div class="portfolio-overlay">
                            <div class="thumb-info">
                                <h5 style="color: blue;">Janja</h5>
                                <i class="icon-plus icon-2x"></i>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>

                <!-- end portfolio item -->

            </div>
        </div>
    </div>
</div>
</section>