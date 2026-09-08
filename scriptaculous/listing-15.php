function updateOrder()
{
    var options = {
                    method : 'post',
                    parameters : Sortable.serialize('movies_list')
                  };
 
    new Ajax.Request('processor.php', options);
}