
<script>
  $(function() {
    var name = $( "#title" ),
      email = $( "#body" ),
      allFields = $( [] ).add( name ).add( email ),
      tips = $( ".validateTips" );
 
    function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }
 
    function checkLength( o, n, min, max ) {
      if ( o.val().length > max || o.val().length < min ) {
        o.addClass( "ui-state-error" );
        updateTips( "Length of " + n + " must be between " +
          min + " and " + max + "." );
        return false;
      } else {
        return true;
      }
    }
 
    function checkRegexp( o, regexp, n ) {
      if ( !( regexp.test( o.val() ) ) ) {
        o.addClass( "ui-state-error" );
        updateTips( n );
        return false;
      } else {
        return true;
      }
    }
 
    $( "#article-form" ).dialog({
      autoOpen: false,
      height: 700,
      width: 900,
      modal: true,
      buttons: {
        "Submit article": function() {
          var bValid = true;
          allFields.removeClass( "ui-state-error" );
 
          /* bValid = bValid && checkLength( name, "username", 3, 16 );
          bValid = bValid && checkLength( email, "email", 6, 80 );
          bValid = bValid && checkLength( password, "password", 5, 16 );
 
          bValid = bValid && checkRegexp( name, /^[a-z]([0-9a-z_])+$/i, "Username may consist of a-z, 0-9, underscores, begin with a letter." );
          // From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
          bValid = bValid && checkRegexp( email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "eg. ui@jquery.com" );
  */
          if ( bValid ) {
           /*  $( "#users tbody" ).append( "<tr>" +
              "<td>" + name.val() + "</td>" +
              "<td>" + email.val() + "</td>" +
              "<td>" + password.val() + "</td>" +
            "</tr>" );
            $( this ).dialog( "close" ); */
              $("#submitform").submit();
          }
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      },
      close: function() {
        allFields.val( "" ).removeClass( "ui-state-error" );
      }
    });
 
    $( "#create-article" )
      .button()
      .click(function() {
        $( "#article-form" ).dialog( "open" );
      });

    $("#column_article").change(function(){
        if(this.value == "column") {
            $(".column_select").show();
            $(".rating_select").hide();
        } else if(this.value == "review") {
        	$(".column_select").hide();
        	$(".rating_select").show();
        } else {
        	$(".column_select").hide();
        	$(".rating_select").hide();
        }
    });
    $(".column_select").hide();
    $(".rating_select").hide();
  });
  </script>

<div id="article-form" title="Create new article">
	<p class="validateTips">All form fields are required.</p>
	<form method="post" action="/IAPT1/member/submit" name="submitform"
		id="submitform" enctype="multipart/form-data">
		<fieldset>
			<label for="title">Title</label> <input type="text"
				name="article[title]" id="title"
				class="text ui-widget-content ui-corner-all" /> <label for="file">Image:</label>
			<input type="file" name="file" id="file"> <label for="type">Article
				Type:</label> <select name="article[type]" id="column_article">
				<option value="article">Article</option>
				<option value="column_article">Column Article</option>
				<option value="review">Review</option>
			</select> <label for="column" class="column_select">Column:</label> <select
				name="article[column_article]" class="column_select">
				<option value="technology">Technology</option>
				<option value="cs_success">CS Success</option>
			</select> <label for="rating" class="rating_select">Rating:</label> <select
				name="article[rating]" class="rating_select">
				<option value="0">0</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select> <label for="keywords" class="keywords">Keywords:</label> <select
				name="article[keywords][]" class="keywords" multiple>
				<option value="tech">Technology</option>
				<option value="department">Department related</option>
			</select> <label for="writers" class="writers">\Other Writers:</label> <select
				name="article[writer][]" class="writers" multiple>
	  <?php
			foreach ( $WriterList as $writer ) {
				echo "<option value=\"" . $writer->getId () . "\">" . $writer->getName () . "</option>";
			}
			?>
	</select> <label for="body">Article Body</label>
			<textarea name="article[body]" id="body"
				class="text ui-widget-content ui-corner-all" rows="15" cols="50"></textarea>
		</fieldset>
	</form>
</div>

<button id="create-article">Create a new article</button>