template.helper('parseJSON',function(content){return $.type(content) == 'string' ? $.parseJSON(content) : content;});
template.helper('encodeJSON',function(content){return content.replace(/"/g,'\\"');});
template.helper('jsonToString',function(json){
	switch($.type(json))
	{
		case "object":
		{
			var itemArray = [];
			for(var index in json)
			{
				itemArray.push('"' + index + '":"' + json[index] + '"');
			}
			return '{'+itemArray.join(",")+'}';
		}
		break;

		case "array":
		{
			var itemArray = [];
			for(var index in json)
			{
				itemArray.push('"'+json[index]+'"');
			}
			return '['+itemArray.join(",")+']';
		}
		break;

		default:
		{
			return json;
		}
		break;
	}
});