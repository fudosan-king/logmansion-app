import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/catalog.dart';
import '../utils/domain.dart';

class CatalogRepository {
  Future<List<Catalog>> fetchCatalogs() async {
    try {
      List<Catalog> catalogs = [];
      final response = await http.get(
        Uri.parse(Domain.getApiUrl("catalogues")),
      );
      if (response.statusCode == 200) {
        catalogs = (json.decode(response.body)['data'] as List)
            .map((data) => Catalog.fromJson(data))
            .toList();
        return catalogs;
      } else {
        throw Exception('Failed to get catalogs');
      }
    } catch (e) {
      throw Exception('Failed to get catalogs');
    }
  }
}
