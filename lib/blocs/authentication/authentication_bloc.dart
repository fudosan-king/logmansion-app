import 'dart:async';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../../models/user.dart';
import '../../repositories/authentication_repository.dart';
import '../../repositories/user_repository.dart';
import 'authentication_event.dart';
import 'authentication_state.dart';

class AuthenticationBloc
    extends Bloc<AuthenticationEvent, AuthenticationState> {
  AuthenticationBloc({
    required AuthenticationRepository authenticationRepository,
    required UserRepository userRepository,
  })  : _authenticationRepository = authenticationRepository,
        _userRepository = userRepository,
        super(const AuthenticationState.unknown()) {
    on<AuthenticationStatusChanged>(_onAuthenticationStatusChanged);
    on<AuthenticationLogoutRequested>(_onAuthenticationLogoutRequested);
    _authenticationStatusSubscription = _authenticationRepository.status.listen(
      (status) => add(AuthenticationStatusChanged(status)),
    );
    _checkToken();
  }

  final AuthenticationRepository _authenticationRepository;
  final UserRepository _userRepository;
  late StreamSubscription<AuthenticationStatus>
      _authenticationStatusSubscription;

  @override
  Future<void> close() {
    _authenticationStatusSubscription.cancel();
    return super.close();
  }

  Future<void> _onAuthenticationStatusChanged(
    AuthenticationStatusChanged event,
    Emitter<AuthenticationState> emit,
  ) async {
    switch (event.status) {
      case AuthenticationStatus.unauthenticated:
        return emit(const AuthenticationState.unauthenticated());
      case AuthenticationStatus.authenticated:
        final user = await _tryGetUser();
        return emit(
          user != null
              ? AuthenticationState.authenticated(user)
              : const AuthenticationState.unauthenticated(),
        );
      case AuthenticationStatus.firstLogin:
        final user = await _tryGetUser();
        return emit(
          user != null
              ? AuthenticationState.firstUpdate(user)
              : const AuthenticationState.unauthenticated(),
        );
      case AuthenticationStatus.unknown:
        return emit(const AuthenticationState.unknown());
    }
  }

  void _onAuthenticationLogoutRequested(
    AuthenticationLogoutRequested event,
    Emitter<AuthenticationState> emit,
  ) {
    _authenticationRepository.logOut();
  }

  Future<User?> _tryGetUser() async {
    try {
      final user = await _userRepository.getUser();
      return user;
    } catch (_) {
      return null;
    }
  }

  Future<void> _checkToken() async {
    final prefs = await SharedPreferences.getInstance();
    final token = prefs.getString('token');
    if (token != null) {
      final user = await _tryGetUser();
      if (user != null) {
        emit(AuthenticationState.authenticated(user));
      } else {
        emit(const AuthenticationState.unauthenticated());
      }
    } else {
      emit(const AuthenticationState.unauthenticated());
    }
  }
}

// import 'package:flutter_bloc/flutter_bloc.dart';
// import 'package:shared_preferences/shared_preferences.dart';
// import 'authentication_event.dart';
// import 'authentication_state.dart';
// import '/repositories/authentication_repository.dart';
//
// class AuthenticationBloc extends Bloc<AuthenticationEvent, AuthenticationState> {
//   final AuthenticationRepository authenticationRepository;
//
//   AuthenticationBloc({required this.authenticationRepository}) : super(AuthenticationInitial()) {
//     on<AuthenticationLoginRequested>(_onLoginRequested);
//   }
//
//   Future<void> _onLoginRequested(
//       AuthenticationLoginRequested event,
//       Emitter<AuthenticationState> emit,
//       ) async {
//     emit(AuthenticationLoading());
//     try {
//       final token = await authenticationRepository.authenticate(
//         email: event.id,
//         password: event.password,
//       );
//
//       if (token != null) {
//         final prefs = await SharedPreferences.getInstance();
//         await prefs.setString('token', token);
//         authenticationRepository.getInfo();
//         emit(AuthenticationSuccess());
//       } else {
//         emit(AuthenticationFailure(error: 'Failed to obtain token'));
//       }
//     } catch (e) {
//       print(e);
//       emit(AuthenticationFailure(error: e.toString()));
//     }
//   }
// }
