import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import '../models/user.dart';
import '/utils/domain.dart';
import 'dart:async';

enum AuthenticationStatus { unknown, authenticated, firstLogin, unauthenticated }

class AuthenticationRepository {

  final _controller = StreamController<AuthenticationStatus>();

  Stream<AuthenticationStatus> get status async* {
    await Future<void>.delayed(const Duration(seconds: 3));
    // yield AuthenticationStatus.unauthenticated;
    yield* _controller.stream;
  }

  Future<void> logIn({
    required String clientID,
    required String password,
  }) async {
    final response = await http.post(
      Uri.parse(Domain.getApiUrl("login")),
      headers: <String, String>{
        'Content-Type': 'application/json; charset=UTF-8',
      },
      body: jsonEncode(<String, String>{
        'client_id': clientID,
        'client_password': password,
      }),
    );
    if (response.statusCode == 200) {
      var token = jsonDecode(response.body)['token'];
      print(jsonDecode(response.body));
      final prefs = await SharedPreferences.getInstance();
      prefs.setString('token', token);
      if(jsonDecode(response.body)['isFirstLogin']){
        _controller.add(AuthenticationStatus.firstLogin);
      }
      else{
        _controller.add(AuthenticationStatus.authenticated);
      }
    } else {
      throw Exception('Failed to authenticate');
    }
  }

  Future<void> logOut() async {
    final prefs = await SharedPreferences.getInstance();
    prefs.remove('token');
    _controller.add(AuthenticationStatus.unauthenticated);
  }

  void dispose() => _controller.close();

  Future updateUserOnFirst({required String email, required String password }) async {
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
      );
      if (response.statusCode == 200) {
        // User user = User.fromJson(jsonDecode(response.body)['user']);
        // _controller.add(AuthenticationStatus.authenticated);
        _controller.add(AuthenticationStatus.unknown);
        return response.body;
      } else if(response.statusCode == 400 || response.statusCode == 401) {
        return response.body;
      } else {
        throw Exception('Failed to update');
      }
    }
    catch(e){
      throw Exception('Failed to update');
    }
  }

  Future forgotPassword({ required String email }) async {
    try{
      final response = await http.post(
        Uri.parse(Domain.getApiUrl("forgot-password")),
        headers: <String, String>{
          'Content-Type': 'application/json; charset=UTF-8',
        },
        body: jsonEncode(<String, String>{
          'client_email': email,
        }),
      );
      return (jsonDecode(response.body));
    }
    catch(e){
      return ;
    }
  }

  Future forgotClientID({ required String email }) async {
    try{
      final response = await http.post(
        Uri.parse(Domain.getApiUrl("forgot-client-id")),
        headers: <String, String>{
          'Content-Type': 'application/json; charset=UTF-8',
        },
        body: jsonEncode(<String, String>{
          'client_email': email,
        }),
      );
      return (jsonDecode(response.body));
    }
    catch(e){
      return ;
    }
  }

  //code cũ

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
    if (response.statusCode == 200) {
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