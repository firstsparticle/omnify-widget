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
<img src='<?php echo plugin_dir_url() . $this->plugin_name; ?>/admin/images/omnifylogo.png' style="width:350px" class="img-rounded" alt="Omnify Inc">
  <div style="margin-top: 70px">
    <h1><strong>Start selling from your existing website</strong></h1>
    <h4>Easily embed Omnify buttons and iframes onto your WordPress site</h4>
  </div>
  <br/>
  <button class="btn btn-primary btn" data-toggle="modal" data-target="#ButtonWidgettModal">Create a Button Widget</button>
  <button class="btn btn-success btn" data-toggle="modal" data-target=".widget-iframe-modal">Create an iFrame Widget</button>
  <br>
</div>
<br/>
<br/>
<br/>
<!-- ButtonWidgettModal -->
<div id="ButtonWidgettModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Customize your Button Widget</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-4">
            <h4>Select Category</h4>
          </div>
          <div class="col-sm-8">
            <select class="selectpicker" title="Select Category" data-width="100%">
              <option>Omnify Website</option>
              <option>Sign In</option>
              <option>Sign Up</option>
              <option>Events</option>
              <option>Facilities</option>
              <option>Memberships</option>
              <option>Classpacks</option>
              <option>Classes</option>
              <option>Appointments</option>
            </select>
          </div>
        </div>
        </br>
        <div class="row selectnamerow">
          <div class="col-sm-4">
            <h4>Select Name</h4>
          </div>
          <div class="col-sm-8">
            <select class="selectpicker" title="Select Category" data-width="100%">
              <option>Class One</option>
              <option>Classpack Two</option>
              <option>Board Game</option>
            </select>
          </div>
        </div>
        <br/>
        <div class="row">
          <div class="col-sm-4">
            <h4>Button Name</h4>
          </div>
          <div class="col-sm-8">
            <input type="text" id='button_name' name="name" value="" class='form-control'/>
          </div>
        </div>
        <br/>
        <div class="row">
          <div class="col-sm-4">
            <h4>Text Color</h4>
          </div>
          <div class="col-sm-8">
            <input name="text_color"  class='input-color color-picker' />
          </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <h4>Button Color</h4>
            </div>
            <div class="col-sm-8">
              <input name="button_color" class='color-picker' />
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Generate Shortcode</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- create iframe width modal -->
<div class="modal fade widget-iframe-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
	  <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Omnify iFrame Widget</h3>
      </div>
	  <div class="modal-body">
	    <div class="row">
	  	  <div class="col-sm-8">
			<iframe class="iframe" src="" frameborder="0" allowfullscreen>
			</iframe>
		  </div>
		  <div class="col-sm-3 iframe-modal-actions">
            <div class="panel panel-default">
                <div class="panel-heading">Enable sections of website</div>
                <ul class="list-group">
					<li class="list-group-item">
                        Header
                        <div class="material-switch pull-right">
                            <input id="header" name="show-header" type="checkbox"/>
                            <label for="header" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Herosection
                        <div class="material-switch pull-right">
                            <input id="herosection" name="show-herosection" type="checkbox"/>
                            <label for="herosection" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Facilities
                        <div class="material-switch pull-right">
                            <input id="facilities" name="show-facilities" type="checkbox"/>
                            <label for="facilities" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Classes
                        <div class="material-switch pull-right">
                            <input id="classes" name="show-classes" type="checkbox"/>
                            <label for="classes" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Classpacks
                        <div class="material-switch pull-right">
                            <input id="classpacks" name="show-classpacks" type="checkbox"/>
                            <label for="classpacks" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Events
                        <div class="material-switch pull-right">
                            <input id="events" name="show-events" type="checkbox"/>
                            <label for="events" class="label-primary"></label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        Memberships
                        <div class="material-switch pull-right">
                            <input id="memberships" name="show-memberships" type="checkbox"/>
                            <label for="memberships" class="label-primary"></label>
                        </div>
                    </li>
					<li class="list-group-item">
                        Appointments
                        <div class="material-switch pull-right">
                            <input id="appointments" name="show-appointments" type="checkbox"/>
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
        <button type="button" class="btn btn-primary">Generate Shortcode</button>
      </div>
    </div>
  </div>
</div>

<br/>
<br/>
<br/>
<hr/>

<div class="container" style="width:70%;">
  <h2>Your Widgets</h2>
  <hr>
  <p>Press 'Copy' button to copy the identifier of the particular widget. Paste the identifier wherever you want in the Wordpress page you created. The button/iframe will show once the page is published.</p>
  <div class="panel panel-default">
    <div class="panel-body">
      <table class="table" style="margin-top: 10px">
        <thead>
          <tr>
            <th>#</th>
            <th>Action</th>
            <th>Widget</th>
            <th>Shortcode</th>
            <th>Update Widget</th>
          </tr>
          <tr>
            <td>1</td>
            <td>Sign up</td>
            <td>Button</td>
            <td>
              <div class="row">
                <div class="col-lg-12">
                  <div class="input-group">
                    <input type="text" class="form-control shortcode" value="[sign_up_1]" disabled />
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-primary">
                        Copy
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            <td>
              <button class="btn btn-warning">View Code</button>
              <button class="btn btn-danger">Delete</button>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>Buy Now</td>
            <td>Button</td>
            <td>
              <div class="row">
                <div class="col-lg-12">
                  <div class="input-group">
                    <input type="text" class="form-control shortcode" value="[classpack_1]" disabled />
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-primary">
                        Copy
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </td>
            <td>
              <button class="btn btn-warning">View Code</button>
              <button class="btn btn-danger">Delete</button>
            </td>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- View Code Modal -->
<div class="modal fade" id="CodeModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body code-modal-body" style="overflow: scroll;">
        <p>NO CODE ASSOSIATED.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
