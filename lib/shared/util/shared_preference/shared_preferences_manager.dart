import 'dart:convert';

import 'package:shared_preferences/shared_preferences.dart';

class Prefs {
  static SharedPreferences? _prefs;

  // call this method from iniState() function of mainApp().
  static Future<SharedPreferences> init() async {
    _prefs = await SharedPreferences.getInstance();
    return _prefs!;
  }

  //sets
  static Future setBool(String key, bool value) async =>
      await _prefs!.setBool(key, value);

  static Future setDouble(String key, double value) async =>
      await _prefs!.setDouble(key, value);

  static Future setInt(String key, int value) async =>
      await _prefs!.setInt(key, value);

  static Future setString(String key, String value) async =>
      await _prefs!.setString(key, value);

  static Future setStringList(String key, List<String> value) async =>
      await _prefs!.setStringList(key, value);

  static Future setMap(String key, Map value) async {
    String json = jsonEncode(value);
    await _prefs!.setString(key, json);
  }

  //gets
  static getBool(String key) => _prefs!.getBool(key);
  static getDouble(String key) => _prefs!.getDouble(key);
  static getInt(String key) => _prefs!.getInt(key);
  static getString(String key) => _prefs!.getString(key);
  static getStringList(String key) => _prefs!.getStringList(key);
  static getMap(String key) {
    String result = _prefs!.getString(key) ?? '{}';
    return jsonDecode(result) as Map;
  }

  //delete
  static Future remove(String key) async => await _prefs!.remove(key);

  static Future clear() async => await _prefs!.clear();
}
