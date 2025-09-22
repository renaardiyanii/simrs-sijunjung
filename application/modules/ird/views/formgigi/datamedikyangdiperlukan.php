
<?php
$gigi = isset($gigi)?$gigi->row():'';
// var_dump($gigi->anamnesis);?>
<div class="col">
    <div class="mb-3">
    <label for="anamnesis" class="form-label"><b>A. Anamnesis</b></label>
    <textarea class="form-control" id="anamnesis" rows="3" name="anamnesis"><?= isset($gigi->anamnesis)?$gigi->anamnesis:''; ?></textarea>
    </div>
</div>
<div style="width:1px;border-right:1px solid grey;">
</div>
