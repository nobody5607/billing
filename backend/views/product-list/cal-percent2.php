<?php    $total = 0;?><table class="table table-bordered">    <thead>        <tr>            <th>ชื่อพนักงาน</th>            <th>ที่เก็บ</th>            <th>Factor</th>            <th>จำนวนเงิน</th>                     </tr>    </thead>    <tbody>        <?php        foreach($drivers as $k=> $driver):?>        <tr>            <td><?= $driver['driver']?></td>            <td><?= $driver['treasury']?></td>            <td>X <?= $driver['factor']?></td>            <td><?php                    $price = $driver['price']*$driver['factor'];                    echo number_format($price, 2);                    $total += $price;                ?></td>                    </tr>        <?php endforeach;?>    </tbody>    <tfoot>        <tr>            <td colspan="4">รวมเงินทั้งหมด</td>            <td><b><?= number_format($total, 2); ?></b> บาท</td>                    </tr>    </tfoot></table>