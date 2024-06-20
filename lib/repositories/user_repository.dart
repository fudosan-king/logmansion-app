import 'dart:convert';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:http/http.dart' as http;

import '../models/user.dart';
import '../utils/domain.dart';

class UserRepository {
  User? _user;

  Future<User?> getUser() async {
    // if (_user != null) return _user;
    try{
      final prefs = await SharedPreferences.getInstance();
      String token = prefs.getString('token')!;
      final response = await http.get(
        Uri.parse(Domain.getApiUrl("client/profile")),
        headers: <String, String>{
          'Authorization': 'Bearer $token',
        },
      );
      if (response.statusCode == 200) {
        _user = User.fromJson(jsonDecode(response.body)['user']);
        return _user;
      } else {
        throw Exception('Failed to get user info');
      }
    }
    catch(e){
      print(e);
      throw Exception('Failed to get user info');
    }
  }

  Future updateUser({required String email, required String password }) async {
    try{
      final prefs = await SharedPreferences.getInstance();
      String token = prefs.getString('token')!;
      final response = await http.post(
        Uri.parse(Domain.getApiUrl("client/update")),
        headers: <String, String>{
          'Authorization': 'Bearer $token',
          'Content-Type': 'application/json; charset=UTF-8',
        },
        body: jsonEncode(<String, String>{
          'email': email,
          'password': password,
        }),
      );print(jsonDecode(response.body));
      if (response.statusCode == 200) {
        _user = User.fromJson(jsonDecode(response.body)['user']);
        return _user;
      } else {
        throw Exception('Failed to update');
      }
    }
    catch(e){
      throw Exception('Failed to update');
    }
  }
}