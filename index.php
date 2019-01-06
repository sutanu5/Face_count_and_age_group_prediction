<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">

                $file-uploader__primaryColor: rgb(114, 191, 167);
                $file-uploader__primaryColor--hover: lighten($file-uploader__primaryColor, 15%);
                $file-uploader__black: #242424;
                $file-uploader__error: rgb(214, 93, 56);

                //style
                .file-uploader {
                  background-color: lighten($file-uploader__primaryColor, 30%);
                  border-radius: 3px;
                  color: $file-uploader__black;
                }

                .file-uploader__message-area {
                  font-size: 18px;
                  padding: 1em;
                  text-align: center;
                  color: darken($file-uploader__primaryColor, 25%);
                }

                .file-list {
                  background-color: lighten($file-uploader__primaryColor, 45%);
                  font-size: 16px;
                }

                .file-list__name {
                  white-space: nowrap;
                  overflow: hidden;
                  text-overflow: ellipsis;
                }

                .file-list li {
                  height: 50px;
                  line-height: 50px;
                  margin-left: .5em;
                  border: none;
                  overflow: hidden;
                }

                .removal-button {
                  width: 20%;
                  border: none;
                  background-color: $file-uploader__error;
                  color: white;

                  &::before {
                    content: 'X'
                  }
                  &:focus {
                    outline: 0;
                  }
                }

                .file-chooser {
                  padding: 1em;
                  transition: background-color 1s, height 1s;
                  & p {
                    font-size: 18px;
                    padding-top: 1em;
                  }
                }

                //layout
                .file-uploader {
                  max-width: 400px;
                  height: auto;
                  margin: 2em auto;

                  & * {
                    display: block;
                  }
                  & input[type=submit] {
                    margin-top: 2em;
                    float: right;
                  }
                }

                .file-list {
                  margin: 0 auto;
                  max-width: 90%;
                }

                .file-list__name {
                  max-width: 70%;
                  float: left;
                }

                .file-list li {
                  @extend %clearfix;
                }

                .removal-button {
                  display: inline-block;
                  height: 100%;
                  float: right;
                }

                .file-chooser {
                  width: 90%;
                  margin: .5em auto;
                }

                .file-chooser__input {
                  margin: 0 auto;
                }

                .file-uploader__submit-button {
                  width: 100%;
                  border: none;
                  font-size: 1.5em;
                  padding: 1em;
                  background-color: #674679;
                  color: white;
                  &:hover {
                    background-color: $file-uploader__primaryColor--hover;
                  }
                }

                //layout
                .file-uploader {
                  @extend %clearfix;
                }

                //utility

                %clearfix {
                  &:after {
                    content:"";
                    display:table;
                    clear:both;
                  }
                }

                .hidden {
                  display: none;
                  & input {
                    display: none;
                  }
                }

                .error {
                  background-color: $file-uploader__error;
                  color: white;
                }

                //reset
                *, *::before, *::after {
                  box-sizing: border-box;
                }
                ul, li {
                  margin: 0;
                  padding: 0;
                }
        
        </style>
    
    
    </head>
<body>
<form method="post" class="file-uploader" action="upload.php" enctype="multipart/form-data">
  <div class="file-uploader__message-area">
    <p>Select a file to upload</p>
  </div>
  <div class="file-chooser">
    <input class="file-chooser__input"  type="file" name="fileToUpload" id="fileToUpload">
  </div>
  <input class="file-uploader__submit-button"  type="submit" value="Upload Image" name="submit">
</form>

    
</body>
</html>





