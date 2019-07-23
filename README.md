# admin-templates
web后台模板，拿来即用

推荐使用[docker-lnmp](https://github.com/rdisme/docker-envs)


## 目录结构

> [v1](#v1)
>> php + [CodeIgniter](http://codeigniter.org.cn/) + [Layui](https://www.layui.com/)




## <span id='v1'>v1</span>

- 用户角色管理
- 用户权限管理

### 注意！

1、目录权限
```
登录涉及的验证码，默认存储在项目根目录 public/images/cache ,
需要保证此目录具有读写权限！
```

2、数据库配置
```
数据库文件在根目录 admin.sql ,
导入到自己的数据中时，需要更改 admin/config/database.php 中配置参数！
```