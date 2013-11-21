
<script>
  $(function() {
    var title = $( "#title" ),
      body = $( "#body" ),
      allFields = $( [] ).add( title ).add( body ),
      tips = $( ".validateTips" );
 
    function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }

    function checkWordsCount(target, name, min, max) {                
    	var text = target.val().trim();
    	var highlight = false; 
        if (target.val().trim() == "" ) {
        	highlight = true;        	
		} else {
	    	var count = text.split(' ').length;   
			if (count < min || count > max) {
				highlight = true;
			}
		}
		if (highlight) {
			target.addClass( "ui-state-error" );
            updateTips( "Length of " + name + " must be between " +
              min + " and " + max + "." );
            return false;
		} else {
			return true;
		}
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
 
    $( "#article-edit-form" ).dialog({
      autoOpen: false,
      height: 700,
      width: 900,
      modal: true,
      buttons: {
        "Update article": function() {
          var bValid = true;
          allFields.removeClass( "ui-state-error" );
 			
          bValid = bValid && checkWordsCount( title, "Title", 1, 20 );
          bValid = bValid && checkWordsCount( body, "Body", 1, 2000 );

          if ( bValid ) {
              $("#submitform").submit();
              $( this ).dialog( "close" );
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
 
    $( "#edit-article" )
      .button()
      .click(function() {
        $( "#article-edit-form" ).dialog( "open" );
      });

    $("#column_article").change(function(){
        if(this.value == "column_article") {
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

<?php
function selectOption($value, $target) {
	if ($value == $target) {
		return "submitted";
	}
}

?>

<div id="article-edit-form" title="Edit article">
	<p class="validateTips">All form fields are required.</p>
	<form method="post"
		action="<?php echo ROOT. "/member/edit/".$Article -> getId() ?>"
		name="editform" id="submitform" enctype="multipart/form-data">
		<fieldset>
			<label for="title">Title</label> <input type="text"
				name="article[title]" id="title"
				class="text ui-widget-content ui-corner-all"
				<?php echo "value=\"".$Article->getTitle(). "\"" ?> /> <label
				for="file">Image:</label> <input type="file" name="file" id="file">
			<label for="type">Article Type:</label> <select name="article[type]"
				id="column_article">
				<option value="article"
					<?php
					selectOption ( "article", $Article->getType () )?>>Article</option>
				<option value="column_article"
					<?php
					
					selectOption ( "column_article", $Article->getType () )?>>Column
					Article</option>
				<option value="review"
					<?php
					
					selectOption ( "review", $Article->getType () )?>>Review</option>
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
			</select> <label for="writers" class="writers">Other Writers:</label>
			<select name="article[writer][]" class="writers" multiple>
	  <?php
			foreach ( $WriterList as $writer ) {
				echo "<option value=\"" . $writer->getId () . "\">" . $writer->getName () . "</option>";
			}
			?>
	</select> <label for="body">Article Body</label>
			<textarea name="article[body]" id="body"
				class="text ui-widget-content ui-corner-all" rows="15" cols="50"><?php echo $Article->getBody() ?></textarea>
		</fieldset>
	</form>
</div>

<button id="edit-article">Edit article</button>

