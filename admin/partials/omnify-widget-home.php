<?php

/**
 * Provide a home view to admin for the plugin
 *
 * @link       https://www.getomnify.com/about-us/
 * @since      1.0.0
 *
 * @package    Omnify_Widget
 * @subpackage Omnify_Widget/admin/partials
 */
?>

<div style="text-align: center; margin-top: 10%">
<img src='<?php echo plugin_dir_url( __FILE__ ); ?>/images/omnifylogo.png' style="width:350px" class="img-rounded" alt="Omnify Inc">
  <div style="margin-top: 70px">
    <h1><strong>Start selling from your existing website</strong></h1>
    <h4>Easily embed Omnify buttons and iframes onto your WordPress site</h4>
  </div>
  <br/>
  <button class="btn btn-primary btn" data-toggle="modal" data-target=".widget-button-modal">Create a Button Widget</button>
  <button class="btn btn-success btn" data-toggle="modal" data-target=".widget-iframe-modal">Create an iFrame Widget</button>
  <br>
</div>
<br/>
<br/>
<br/>

<!-- create button widget modal -->
<div class="modal fade widget-button-modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title">Customize your Button Widget</h2>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-4 button-widget-labels">
            <p>Select Category</p>
          </div>
          <div class="col-sm-8">
            <select class="selectpicker" name="category" title="Select Category" data-width="100%">
              <option value="website">Omnify Website</option>
              <option value="login">Sign In</option>
              <option value="signup">Sign Up</option>
              <option value="events">Events</option>
              <option value="facilities">Facilities</option>
              <option value="memberships">Memberships</option>
              <option value="classpacks">Classpacks</option>
              <option value="classes">Classes</option>
              <option value="appointments">Appointments</option>
            </select>
          </div>
        </div>
        </br>
        <div class="row selectnamerow">
          <div class="col-sm-4 button-widget-labels">
            <p>Select Service</p>
          </div>
          <div class="col-sm-8">
            <select title="Select Category" name="select-service" data-width="100%">
            </select>
          </div>
        </div>
        <br/>
        <div class="row">
          <div class="col-sm-4 button-widget-labels">
            <p>Button Name</p>
          </div>
          <div class="col-sm-8">
            <input type="text" id='button_name' name="name" placeholder="Your Button Name" class='form-control'/>
          </div>
        </div>
        <br/>
        <div class="row">
          <div class="col-sm-4 button-widget-labels">
            <p>Text Color</p>
          </div>
          <div class="col-sm-8">
            <input name="text_color"  class='input-color color-picker' />
          </div>
          </div>
          <div class="row">
            <div class="col-sm-4 button-widget-labels">
              <p>Button Color</p>
            </div>
            <div class="col-sm-8">
              <input name="button_color" class='color-picker' />
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="generate-button-btn">Generate Shortcode</button>
      </div>
    </div>
  </div>
</div>

<!-- create iframe width modal -->
<div class="modal fade widget-iframe-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
	  <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Omnify iFrame Widget</h3>
      </div>
	  <div class="modal-body">
	    <div class="row">
	  	  <div class="col-sm-8">
			<iframe class="iframe-view" src="" frameborder="0" allowfullscreen>
			</iframe>
		  </div>
		  <div class="col-sm-3 iframe-modal-actions">
            <div class="panel panel-default">
                <div class="panel-heading">Enable sections of website</div>
                <ul class="list-group">
					<li class="list-group-item">
                        Header
                        <div class="material-switch pull-right">
                            <input id="header" class="iframe-check" name="show-header" type="checkbox"/>
                            <label for="header" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Herosection
                        <div class="material-switch pull-right">
                            <input id="herosection" class="iframe-check" name="show-herosection" type="checkbox"/>
                            <label for="herosection" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Facilities
                        <div class="material-switch pull-right">
                            <input id="facilities" class="iframe-check" name="show-facilities" type="checkbox"/>
                            <label for="facilities" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Classes
                        <div class="material-switch pull-right">
                            <input id="classes" name="show-classes" class="iframe-check" type="checkbox"/>
                            <label for="classes" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Classpacks
                        <div class="material-switch pull-right">
                            <input id="classpacks" name="show-classpacks" class="iframe-check" type="checkbox"/>
                            <label for="classpacks" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Events
                        <div class="material-switch pull-right">
                            <input id="events" name="show-events" class="iframe-check" type="checkbox"/>
                            <label for="events" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Memberships
                        <div class="material-switch pull-right">
                            <input id="memberships" name="show-memberships" class="iframe-check" type="checkbox"/>
                            <label for="memberships" class="label-primary"></label>
                        </div>
                    </li>
					<li class="list-group-item">
                        Appointments
                        <div class="material-switch pull-right">
                            <input id="appointments" name="show-appointments" class="iframe-check" type="checkbox"/>
                            <label for="appointments" class="label-primary"></label>
                        </div>
                    </li>
					<li class="list-group-item">
					  <div class="row">
						<label for="iframe-height" class="number-labels">Height: </label>
						<input type="number" class="number-inputs" id="iframe-height" placeholder="px." />
						<label for="iframe-width" class="number-labels">Width: </label>
						<input type="number" class="number-inputs" id="iframe-width" placeholder="px." />
					  </div>
                    </li>
                </ul>
            </div>            
		  </div>
		</div>
	  </div>
	  <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="generate-iframe-btn">Generate Shortcode</button>
      </div>
    </div>
  </div>
</div>


<!-- View Code Modal -->
<div class="modal fade view-code-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2>Widget Code</h2>
      </div>
      <div class="modal-body">
        <div class="form-group">
        <textarea class="form-control" rows="9" id="widget-source-code"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php
// set variables
echo "<script> var token = '$token'; </script>";
?>
