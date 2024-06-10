import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import '/utils/domain.dart';

class AuthenticationRepository {

  Future<String?> authenticate({required String email, required String password}) async {
    final response = await http.post(
      Uri.parse(Domain.getApiUrl("login")),
      headers: <String, String>{
        'Content-Type': 'application/json; charset=UTF-8',
      },
      body: jsonEncode(<String, String>{
        'client_email': email,
        'client_password': password,
      }),
    );

    if (response.statusCode == 200) {
      return jsonDecode(response.body)['token'];
    } else {

      throw Exception('Failed to authenticate');
    }
  }

  Future<String?> getInfo() async {
    final prefs = await SharedPreferences.getInstance();
    String token = prefs.getString('token')!;
    final response = await http.get(
      Uri.parse(Domain.getApiUrl("client/profile")),
      headers: <String, String>{
        'Authorization': 'Bearer $token',
      },
    );
    print(jsonDecode(response.statusCode.toString()));
    if (response.statusCode == 200) {
      print(jsonDecode(response.body));
      return jsonDecode(response.body)['token'];
    } else {
      throw Exception('Failed to authenticate');
    }
  }

  Future<String?> changePassword({required String old_password, required String password, required String password_confirmation}) async {
    final prefs = await SharedPreferences.getInstance();
    String token = prefs.getString('token')!;
    final response = await http.post(
      Uri.parse(Domain.getApiUrl("client/change-password")),
      headers: <String, String>{
        'Content-Type': 'application/json; charset=UTF-8',
        'Authorization': 'Bearer $token',
      },
      body: jsonEncode(<String, String>{
        'old_password': old_password,
        'password': password,
        'password_confirmation': password_confirmation,
      }),
    );

    if (response.statusCode == 200) {
      return jsonDecode(response.body)['token'];
    } else {

      throw Exception('Failed to authenticate');
    }
  }
}