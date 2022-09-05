
<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Name *</label>
<div class="col-md-10">
<input type="text" class="form-control required" name="from_name" id="from_name" maxlength="100"  placeholder="Client / Company Name">
</div>
</div>
</div>

<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Email*</label>
<div class="col-md-8">
<input type="text" class="form-control required email" name="from_email" id="from_email" maxlength="100" >
</div>
</div>
</div>

<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Phone*</label>
<div class="col-md-8">
<input type="text" class="form-control required" name="from_phone" id="from_phone" maxlength="50"  minlength="10" onkeyup="chkphonenumber(this.value);">
<span id="pnoresponse"></span>
</div>
</div>
</div>

<div class="col-md-12">
<div class="form-group row">
<label class="col-md-2 col-form-label">Website</label>
<div class="col-md-10">
<input type="text" class="form-control" name="from_website" id="from_website" >
</div>
</div>
</div>



<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">Country</label>
<div class="col-md-8">
<input type="text" class="form-control" name="from_country" id="from_country" maxlength="100" >
</div>
</div>
</div>

<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">State</label>
<div class="col-md-8">
<input type="text" class="form-control" name="from_state" id="from_state" maxlength="100" >
</div>
</div>
</div>


<div class="col-md-6">
<div class="form-group row">
<label class="col-md-4 col-form-label">City</label>
<div class="col-md-8">
<input type="text" class="form-control " name="from_city" id="from_city" maxlength="100"  >
</div>
</div>
</div>


<div class="col-md-12">
<div class="form-group row">

<table class="table table-striped mb-0" width="100%">
<thead>

<tr class="item_header">
<th width="30%" class="text-center">Customer / Company Social media platform</th>
<th width="60%" class="text-center">Social media  platform Url </th>
<th></th>
</tr>
</thead>
<tbody id="invDataTableRow">
<tr>
<td><input type="text" class="form-control text-center " id="platforms0" name="socialmedia[0][platform]" placeholder="Enter Social media platform"></td>
<td><input type="text" class="form-control text-center" id="link0" name="socialmedia[0][link]" placeholder="Enter Social media platform url"></td>
<td></td>
</tr>
</tbody>
<tfoot>

<tr class="last-item-row">
<td class="add-row" align="right" colspan="9">
<button type="button" class="btn btn-success" aria-label="Left Align"  onclick="addFilterRow();"><i class="icon-plus-square"></i> Add Row</button>
</td>
</tr>
<tr>


</tr>
</tfoot>
</table>


</div>
</div>


