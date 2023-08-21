import 'package:ovo_clone/shared/util/shared_preference/shared_preferences_manager.dart';

class UserService {
  doLogin(Map item) async {
    List dataUser = item['email'].split('@');
    Map user = {
      "name": dataUser[0],
      "email": item['email'],
    };
    await Prefs.setMap('user', user);
  }
}
