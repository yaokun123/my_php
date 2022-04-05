Yaf支持用户定义插件来扩展Yaf的功能, 这些插件都是一些类. 它们都必须继承自Yaf_Plugin_Abstract
插件要发挥功效, 也必须现实的在Yaf中进行注册, 然后在适当的实际, Yaf就会调用它

Yaf支持的Hook,Yaf定义了6个Hook


触发顺序	    名称	                        触发时机	                说明
1	        routerStartup	            在路由之前触发	            这个是7个事件中, 最早的一个. 但是一些全局自定的工作, 还是应该放在Bootstrap中去完成
2	        routerShutdown	            路由结束之后触发	        此时路由一定正确完成, 否则这个事件不会触发
3	        dispatchLoopStartup	        分发循环开始之前被触发
4	        preDispatch	                分发之前触发	            如果在一个请求处理过程中, 发生了forward, 则这个事件会被触发多次
5	        postDispatch	            分发结束之后触发	        此时动作已经执行结束, 视图也已经渲染完成. 和preDispatch类似, 此事件也可能触发多次
6	        dispatchLoopShutdown	    分发循环结束之后触发	    此时表示所有的业务逻辑都已经运行完成, 但是响应还没有发送


 插件目录
 一般的, 插件应该放置在APPLICATION_PATH下的plugins目录, 这样在自动加载的时候, 加载器通过类名, 发现这是个插件类, 就会在这个目录下查找.
 当然, 插件也可以放在任何你想放置的地方, 只要你能把这个类加载进来就可以