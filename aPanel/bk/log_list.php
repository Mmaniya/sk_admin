<table width="100%" border="0" class="table-bordered">
    <thead>
    <tr class="bg-primary text-white">
        <th>#</th>
        <th>Date</th>
        <th>Processed By</th>
        <th>Description</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $key=0;
    if(count($logRes) > 0)
        foreach($logRes as $K => $V) {
            $bgColor = '#f5f5f5';
            if($K%2==0) $bgColor = '#ffffff';
            $logObj->record=$V;
            $loggerName=$logObj->getLoggerName();
            ?>
            <tr style="background-color: <?php echo $bgColor;?>">
                <td style="vertical-align: top"><?php echo ++$key;?></td>
                <td style="vertical-align: top"><?php echo date("m/d/Y H:i",strtotime($V->added_date));?></td>
                <td style="vertical-align: top"><?php echo $loggerName." (".$V->user_type.")";?></td>
                <td style="vertical-align: top"><?php echo urldecode($V->description);?></td>
            </tr>
        <?php } else {?>
        <tr>
            <td colspan="4">No logs found.</td>
        </tr>
    <?php } ?>
    </tbody>
</table>