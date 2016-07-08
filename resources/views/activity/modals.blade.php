
<!-- Modals for Activity -->

<!-- Delete item -->
<div class="modal fade" id="modal_activity_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete Activity</h4>
        </div>
        <div class="modal-body">
          <p>Please, confirm</p>
        </div>
        <div class="modal-footer">
            <form >
                <input type="hidden" name="activity_id" id="activity_id" value=""/>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                <button type="button" id="modal_button_delete" class="btn btn-danger" >Delete</button>
            </form>
       </div>
      </div>

</div>
</div>

<!-- Close edition -->
<div class="modal fade" id="modal_activity_close" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Close Details</h4>
        </div>
        <div class="modal-body">
          <p>Some fields were changed. Please, confirm</p>
        </div>
        <div class="modal-footer">
            <form >
                <button type="button" class="btn btn-primary" onclick="window.location.href='/admin/activity';return true;">Close, No Save</button>
                 <button type="button" class="btn btn-primary" data-dismiss="modal">Keep Editing</button>
                <button type="button" id="modal_button_save" class="btn btn-primary" >Save & Close</button>
            </form>
       </div>
      </div>

</div>
</div>
