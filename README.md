## Model
```
class User extends Model
{
    use CrowleyFilterable;
    ..........
}
```
## Controller
```
$user = User::filter($request->all());
return $user->get();
```
