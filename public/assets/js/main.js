function search_paket(group_id){
    var query = $('#src_pkt'+group_id).val();
    var gr_cat = $('#src_groupcat'+group_id).val();
    var order_id = $('#orderid_addcart'+group_id).val();
    var client = $('#client'+group_id).val();
    
    $.ajax({
        url:client+'/live/paket/product_search?query='+query+'&gr_cat='+gr_cat+'&order_id='+order_id,
        dataType:'json',
        success:function(data)
        {
            $('#paket_cari'+group_id).html(data.table_data);
            //$('#total_records').text(data.total_data);
        }
    });
}

