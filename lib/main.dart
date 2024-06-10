import 'package:flutter/material.dart';
import 'app.dart';
import 'repositories/authentication_repository.dart';

void main() {
  final AuthenticationRepository authenticationRepository = AuthenticationRepository();

  runApp(App(authenticationRepository: authenticationRepository));
}
