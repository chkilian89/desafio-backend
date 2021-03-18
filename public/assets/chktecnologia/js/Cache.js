function Cache(){[native/code]};

Cache.conf = Object.freeze({
	storage : window.localStorage,
	prefix  : 'Cache_'
});
Cache.set = function(key,value)
{
	Cache.conf.storage.setItem(Cache.conf.prefix+key,JSON.stringify(value));
};
Cache.get = function(key)
{
	return JSON.parse(Cache.conf.storage.getItem(Cache.conf.prefix+key));
};
Cache.has = function(key)
{
	return Cache.conf.storage.hasOwnProperty(Cache.conf.prefix+key);
};
Cache.delete = function(key)
{
	Cache.conf.storage.removeItem(Cache.conf.prefix+key);
};
Cache.clear = function()
{
	Cache.conf.storage.clear();
};