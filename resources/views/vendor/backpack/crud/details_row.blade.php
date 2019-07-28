<div class="m-t-10 m-b-10 p-l-10 p-r-10 p-t-10 p-b-10">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Size</th>
            <th>Color</th>
        </tr>
        </thead>
        <tbody>
        @foreach($entry->lines as $line)
            <tr>
                <td>{$line->product->title}</td>
                <td>{$line->quantity}</td>
                <td>{$line->total_cost}</td>
                <td>{$line->size}</td>
                <td>{$line->color}</td>
            </tr>

        @endforeach
        </tbody>
    </table>

</div>
<div class="clearfix"></div>